<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;

class MidtransController extends Controller
{
    /**
     * WEBHOOK RESMI MIDTRANS
     *
     * URL ini harus didaftarkan di Dasbor Midtrans:
     *   Sandbox  : https://dashboard.sandbox.midtrans.com -> Pengaturan -> Payment -> URL notifikasi pembayaran
     *   Produksi : https://dashboard.midtrans.com         -> Pengaturan -> Payment -> URL notifikasi pembayaran
     *
     * Isi endpoint yang dimasukkan:
     *   Lokal (dev)   : (kosongkan, tidak bisa diakses dari luar)
     *   Hosting/VPS   : https://namadomainanda.com/midtrans/webhook
     *
     * Rute ini dikecualikan dari CSRF di bootstrap/app.php
     */
    public function webhook(Request $request)
    {
        // ── 1. Verifikasi Tanda Tangan Midtrans ────────────────────────────────
        $serverKey = config('midtrans.server_key');
        $hashed    = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($hashed !== $request->signature_key) {
            Log::warning('[Midtrans Webhook] Invalid signature', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // ── 2. Cari Transaksi Berdasarkan midtrans_order_id ───────────────────
        // Field ini disimpan saat generateSnapToken() dipanggil
        $transaction = Transaction::with('details.productable', 'member')
            ->where('midtrans_order_id', $request->order_id)
            ->first();

        if (!$transaction) {
            // Fallback: cari via transaction_code (kompatibel dengan data lama)
            $transactionCode = explode('-', $request->order_id)[0];
            $transaction     = Transaction::with('details.productable', 'member')
                ->where('transaction_code', $transactionCode)
                ->first();
        }

        if (!$transaction) {
            Log::error('[Midtrans Webhook] Transaction not found', ['order_id' => $request->order_id]);
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        Log::info('[Midtrans Webhook] Received', [
            'order_id'           => $request->order_id,
            'transaction_status' => $request->transaction_status,
            'payment_type'       => $request->payment_type,
        ]);

        // ── 3. Proses Status Pembayaran ───────────────────────────────────────
        $status = $request->transaction_status;

        if (in_array($status, ['capture', 'settlement'])) {

            // Cegah proses ganda
            if ($transaction->payment_status === 'lunas') {
                return response()->json(['message' => 'Already settled']);
            }

            DB::beginTransaction();
            try {
                // a) Kurangi stok setiap item pesanan
                foreach ($transaction->details as $detail) {
                    $product = $detail->productable;
                    if ($product) {
                        $product->decrement('stock', $detail->quantity);
                    }
                }

                // b) Tambahkan poin reward ke member (jika ada)
                if ($transaction->member_id && $transaction->earned_points > 0) {
                    $transaction->member->increment('points', $transaction->earned_points);
                }

                // c) Update status transaksi
                $transaction->update([
                    'payment_status' => 'lunas',
                    'order_status'   => 'diproses',
                    'paid_amount'    => $transaction->final_total,
                ]);

                DB::commit();

                Log::info('[Midtrans Webhook] Transaction settled', ['id' => $transaction->id]);

            } catch (\Throwable $e) {
                DB::rollBack();
                Log::error('[Midtrans Webhook] Failed to settle', [
                    'id'    => $transaction->id,
                    'error' => $e->getMessage(),
                ]);
                return response()->json(['message' => 'Internal error'], 500);
            }

        } elseif (in_array($status, ['expire', 'cancel', 'deny'])) {

            $transaction->update(['payment_status' => 'gagal']);
            Log::info('[Midtrans Webhook] Transaction failed/expired', ['id' => $transaction->id]);
        }

        return response()->json(['message' => 'OK']);
    }
}
