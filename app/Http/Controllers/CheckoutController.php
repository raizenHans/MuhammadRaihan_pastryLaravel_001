<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\Member;
use App\Models\Reward;

class CheckoutController extends Controller
{
    // Menampilkan halaman form checkout
    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();
        $cartItems = Cart::where('session_id', $sessionId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $cartItems->sum('subtotal');

        return view('customer.checkout', compact('cartItems', 'total'));
    }

    /**
     * AJAX: Ambil info member + daftar reward yang bisa diklaim
     */
    public function memberInfo(Request $request)
    {
        $memberCode = $request->query('code');

        if (!$memberCode) {
            return response()->json(['success' => false, 'message' => 'Kode member kosong.'], 422);
        }

        $member = Member::with('user')->where('member_code', $memberCode)
                        ->first();

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Kode Member tidak ditemukan atau tidak aktif.']);
        }

        // Ambil reward aktif yang poin syaratnya <= poin member
        $availableRewards = Reward::where('is_active', true)
            ->where('points_required', '<=', $member->points)
            ->where(function($q) {
                $q->where('stock', 0)->orWhere('stock', '>', 0);
            })
            ->orderBy('points_required', 'asc')
            ->get()
            ->map(fn($r) => [
                'id'              => $r->id,
                'name'            => $r->name,
                'points_required' => $r->points_required,
                'description'     => $r->description,
                'image_url'       => $r->image_path ? asset('storage/' . $r->image_path) : null,
                'stock'           => $r->stock,
            ]);

        return response()->json([
            'success'           => true,
            'member_name'       => $member->user->name ?? $member->member_code,
            'member_code'       => $member->member_code,
            'points'            => $member->points,
            'available_rewards' => $availableRewards,
        ]);
    }

    // Memproses pesanan dari keranjang ke tabel transaksi
    public function process(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:100',
            'member_code'      => 'nullable|string|max:50',
            'claimed_reward_id' => 'nullable|integer|exists:rewards,id',
        ]);

        $sessionId = $request->session()->getId();
        $cartItems = Cart::where('session_id', $sessionId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('catalog')->with('error', 'Keranjang sudah kedaluwarsa atau kosong.');
        }

        $totalBelanja   = $cartItems->sum('subtotal');
        $memberId       = null;
        $potongan       = 0;
        $poinBertambah  = 0;
        $redeemedPoints = 0;
        $claimedRewardId   = null;
        $claimedRewardName = null;

        // Cek kode member
        if ($request->filled('member_code')) {
            $member = Member::with('user')->where('member_code', $request->member_code)
                            ->first();

            if (!$member) {
                return back()->withInput()->with('error', 'Kode Member tidak ditemukan atau tidak aktif.');
            }

            $memberId = $member->id;

            // Diskon tiering
            if ($totalBelanja >= 900000)      $potongan = 85000;
            elseif ($totalBelanja >= 500000)  $potongan = 50000;
            elseif ($totalBelanja >= 300000)  $potongan = 30000;
            elseif ($totalBelanja >= 200000)  $potongan = 20000;
            elseif ($totalBelanja >= 100000)  $potongan = 10000;

            // Poin bonus (tiap kelipatan 50.000 → 25 poin)
            $poinBertambah = floor($totalBelanja / 50000) * 25;

            // Klaim reward
            if ($request->filled('claimed_reward_id')) {
                $reward = Reward::find($request->claimed_reward_id);

                if ($reward && $reward->is_active && $member->points >= $reward->points_required) {
                    $redeemedPoints    = $reward->points_required;
                    $claimedRewardId   = $reward->id;
                    $claimedRewardName = $reward->name;

                    // Kurangi poin member
                    $member->points -= $redeemedPoints;

                    // Kurangi stok hadiah jika stok dibatasi (> 0)
                    if ($reward->stock > 0) {
                        $reward->stock = max(0, $reward->stock - 1);
                        $reward->save();
                    }
                }
            }

            // Tambah poin baru dari belanja
            $member->points += $poinBertambah;
            $member->save();
        }

        $totalAkhir = max(0, $totalBelanja - $potongan);

        \DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'transaction_code'   => 'TRX' . date('YmdHis') . rand(100, 999),
                'member_id'          => $memberId,
                'customer_name'      => $request->customer_name,
                'total_amount'       => $totalBelanja,
                'discount'           => $potongan,
                'final_total'        => $totalAkhir,
                'earned_points'      => $poinBertambah,
                'redeemed_points'    => $redeemedPoints,
                'claimed_reward_id'  => $claimedRewardId,
                'claimed_reward_name'=> $claimedRewardName,
                'order_status'       => 'pending',
                'payment_status'     => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $transaction->details()->create([
                    'productable_type' => $item->productable_type,
                    'productable_id'   => $item->productable_id,
                    'product_code'     => $item->productable->product_code ?? 'UNKNOWN',
                    'product_name'     => $item->product_name,
                    'quantity'         => $item->quantity,
                    'unit_price'       => $item->price,
                    'subtotal'         => $item->subtotal,
                    'final_subtotal'   => $item->subtotal,
                ]);
            }

            Cart::where('session_id', $sessionId)->delete();

            \DB::commit();

            $request->session()->regenerate();

            return redirect()->route('receipt', $transaction->id)
                             ->with('success', 'Pesanan berhasil dibuat! Silakan menuju kasir untuk pembayaran.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // Menampilkan halaman struk / nomor pesanan
    public function receipt($id)
    {
        $transaction = Transaction::with(['details', 'member'])->findOrFail($id);
        return view('customer.receipt', compact('transaction'));
    }
}