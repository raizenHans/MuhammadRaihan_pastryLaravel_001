<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // Menampilkan daftar pesanan yang masih 'pending' untuk modul KASIR AKTIF
    public function index()
    {
        $pendingOrders = Transaction::with('details')->where('payment_status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('operator.orders.index', compact('pendingOrders'));
    }

    // Eksekusi pelunasan via halaman kasir normal
    public function pay(Request $request, $id)
    {
        $transaction = Transaction::with('details', 'member')->findOrFail($id);

        if ($transaction->payment_status !== 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'payment_method' => 'required|string',
            'paid_amount'    => 'nullable|numeric',
        ]);

        $kembalian = ($request->paid_amount ?? $transaction->final_total) - $transaction->final_total;

        DB::beginTransaction();
        try {
            foreach ($transaction->details as $detail) {
                $product = $detail->productable;
                if ($product) {
                    if ($product->stock < $detail->quantity) {
                        throw new \Exception("Stok {$product->name} tidak mencukupi (Sisa: {$product->stock}).");
                    }
                    $product->decrement('stock', $detail->quantity);
                }
            }

            if ($transaction->member_id && $transaction->earned_points > 0) {
                $transaction->member->increment('points', $transaction->earned_points);
            }

            $transaction->update([
                'payment_status' => 'lunas',
                'order_status'   => 'diproses',
                'paid_amount'    => $request->paid_amount ?? $transaction->final_total,
                'change_amount'  => max(0, $kembalian),
                'payment_method' => $request->payment_method,
                'operator_id'    => Auth::id()
            ]);

            DB::commit();
            return back()->with('success', 'Transaksi LUNAS! Kembalian: Rp ' . number_format(max(0, $kembalian), 0, ',', '.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // ===============================================
    // FITUR RIWAYAT & MANAJEMEN TRANSAKSI (AJAX)
    // ===============================================

    public function history()
    {
        $stats        = $this->getStatistics();
        // Gunakan withTrashed agar revenue tidak berkurang saat record di-soft-delete
        $totalRevenue = Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total');

        $orders = Transaction::with(['member', 'details'])->latest()->get();
        return view('operator.orders.history', compact('orders', 'stats', 'totalRevenue'));
    }

    public function historyFilter(Request $request)
    {
        $query = Transaction::with(['member', 'details']);

        if ($request->filled('status') && $request->status !== '') {
            $query->where('order_status', $request->status);
        }
        if ($request->filled('payment_status') && $request->payment_status !== '') {
            $query->where('payment_status', $request->payment_status);
        }
        if ($request->filled('date') && $request->date !== '') {
            $query->whereDate('created_at', $request->date);
        }
        if ($request->filled('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'LIKE', "%$search%")
                  ->orWhere('transaction_code', 'LIKE', "%$search%")
                  ->orWhereHas('member', function ($qm) use ($search) {
                      $qm->where('member_code', 'LIKE', "%$search%");
                  });
            });
        }

        $query->orderBy('created_at', 'desc');

        $orders = $query->get();

        $stats        = $this->getStatistics();
        $totalRevenue = Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total');

        $html = view('operator.orders.partials.history_table', compact('orders'))->render();

        return response()->json([
            'success'       => true,
            'html'          => $html,
            'stats'         => $stats,
            'total_revenue' => $totalRevenue,
            'count'         => $orders->count()
        ]);
    }

    public function updateOrderStatusAjax(Request $request)
    {
        try {
            $transaction = Transaction::findOrFail($request->id_pemesanan);
            $transaction->update(['order_status' => $request->status]);

            return response()->json([
                'success'       => true,
                'message'       => 'Status pesanan berhasil diupdate!',
                'stats'         => $this->getStatistics(),
                'total_revenue' => Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function updatePaymentStatusAjax(Request $request)
    {
        try {
            $transaction = Transaction::findOrFail($request->id_pemesanan);
            $transaction->update(['payment_status' => $request->payment_status]);

            return response()->json([
                'success'       => true,
                'message'       => 'Status pembayaran berhasil diupdate!',
                'stats'         => $this->getStatistics(),
                'total_revenue' => Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total')
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    /**
     * Hapus riwayat pesanan dari tampilan (soft delete).
     * Stok HANYA dikembalikan jika transaksi belum lunas.
     * Total pendapatan TIDAK berkurang karena menggunakan withTrashed() di query revenue.
     */
    public function deleteOrderAjax(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::with('details', 'member')->findOrFail($request->id_pemesanan);

            // Kembalikan stok HANYA jika pesanan belum lunas (belum diproses)
            if ($transaction->payment_status !== 'lunas') {
                foreach ($transaction->details as $detail) {
                    $product = $detail->productable;
                    if ($product) {
                        $product->increment('stock', $detail->quantity);
                    }
                }

                // Kembalikan poin jika ada yang di-redeem
                if ($transaction->member_id && $transaction->redeemed_points > 0) {
                    $transaction->member->increment('points', $transaction->redeemed_points);
                }
            }

            // Soft delete — record tetap ada di DB tapi tidak tampil di history
            // Revenue tetap terhitung via withTrashed()
            $transaction->delete();

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Pesanan dihapus dari riwayat.' . ($transaction->payment_status !== 'lunas' ? ' Stok telah dikembalikan.' : ''),
                'stats'         => $this->getStatistics(),
                'total_revenue' => Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    /**
     * Proses pembayaran CASH dari modal history
     */
    public function processPaymentAjax(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaction  = Transaction::findOrFail($request->id_pemesanan);
            $uang_dibayar = (float) $request->uang_dibayar;
            $kembalian    = $uang_dibayar - $transaction->final_total;

            if ($kembalian < 0) {
                return response()->json(['success' => false, 'message' => 'Jumlah uang kurang dari tagihan.']);
            }

            $transaction->update([
                'payment_status' => 'lunas',
                'payment_method' => 'Cash',
                'paid_amount'    => $uang_dibayar,
                'change_amount'  => $kembalian,
                'operator_id'    => Auth::id()
            ]);

            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Pembayaran Cash berhasil! Kembalian: Rp ' . number_format($kembalian, 0, ',', '.'),
                'stats'         => $this->getStatistics(),
                'total_revenue' => Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    /**
     * Generate Midtrans Snap Token untuk QRIS/E-Wallet/Virtual Account
     * Dipanggil dari modal payment history ketika operator memilih metode QRIS/E-wallet
     */
    public function generateSnapToken(Request $request)
    {
        try {
            $transaction = Transaction::findOrFail($request->id_pemesanan);

            if ($transaction->payment_status === 'lunas') {
                return response()->json(['success' => false, 'message' => 'Transaksi sudah lunas.']);
            }

            Config::$serverKey    = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized  = true;
            Config::$is3ds        = true;

            $orderId = $transaction->transaction_code . '-' . time();
            $payload = [
                'transaction_details' => [
                    'order_id'     => $orderId,
                    'gross_amount' => (int) $transaction->final_total,
                ],
                'customer_details' => [
                    'first_name' => $transaction->customer_name,
                ]
            ];

            $snapToken = Snap::getSnapToken($payload);

            $bank = $request->bank ?? 'Online';

            // Simpan order_id Midtrans ke payment_method sementara (tracking)
            $transaction->update([
                'payment_method' => 'Midtrans/' . strtoupper($bank),
                'operator_id'    => Auth::id()
            ]);

            return response()->json([
                'success'    => true,
                'snap_token' => $snapToken,
                'order_id'   => $transaction->id,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membuat token Midtrans: ' . $e->getMessage() . ' di baris ' . $e->getLine()]);
        }
    }

    /**
     * Callback lokal setelah Midtrans Snap berhasil
     */
    public function handleMidtransCallbackLocal(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::with('details', 'member')->findOrFail($request->order_id);

            if ($transaction->payment_status === 'lunas') {
                return response()->json(['success' => true, 'message' => 'Sudah lunas.']);
            }

            // Decrement stok
            foreach ($transaction->details as $detail) {
                $product = $detail->productable;
                if ($product) {
                    $product->decrement('stock', $detail->quantity);
                }
            }

            // Tambah poin member
            if ($transaction->member_id && $transaction->earned_points > 0) {
                $transaction->member->increment('points', $transaction->earned_points);
            }

            $transaction->update([
                'payment_status' => 'lunas',
                'order_status'   => 'diproses',
                'paid_amount'    => $transaction->final_total,
                'operator_id'    => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success'       => true,
                'stats'         => $this->getStatistics(),
                'total_revenue' => Transaction::withTrashed()->where('payment_status', 'lunas')->sum('final_total')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    private function getStatistics()
    {
        return [
            'total_orders'       => Transaction::count(),
            'pending_orders'     => Transaction::where('order_status', 'pending')->count(),
            'processing_orders'  => Transaction::where('order_status', 'diproses')->count(),
            'completed_orders'   => Transaction::where('order_status', 'selesai')->count(),
            'cancelled_orders'   => Transaction::where('order_status', 'dibatalkan')->count(),
            'revenue_today'      => Transaction::withTrashed()->where('payment_status', 'lunas')
                                        ->whereDate('created_at', date('Y-m-d'))
                                        ->sum('final_total')
        ];
    }
}