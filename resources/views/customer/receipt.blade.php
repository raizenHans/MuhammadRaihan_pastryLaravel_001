@extends('layouts.app')
@section('title', 'Pesanan Berhasil — Artorious Pastry')

@push('styles')
<style>
@keyframes successPop {
    0%   { transform: scale(0) rotate(-10deg); opacity: 0; }
    60%  { transform: scale(1.12) rotate(3deg); opacity: 1; }
    100% { transform: scale(1) rotate(0deg); opacity: 1; }
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes codeGlow {
    0%, 100% { text-shadow: 0 0 0 transparent; }
    50%       { text-shadow: 0 0 18px rgba(201,168,76,0.5); }
}
.receipt-card {
    background: #fff;
    border: 1px solid #E2D9CC;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 12px 50px rgba(13,13,13,0.1);
    animation: slideUp 0.5s cubic-bezier(0.16,1,0.3,1);
}
.receipt-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid #F0EAE0;
    align-items: center;
}
.receipt-row:last-child { border-bottom: none; }
.receipt-label {
    font-family: 'Lato', sans-serif;
    font-size: 0.82rem;
    color: #6B6560;
}
.receipt-value {
    font-family: 'Lato', sans-serif;
    font-size: 0.85rem;
    font-weight: 700;
    color: #0D0D0D;
    text-align: right;
}
.receipt-action-btn {
    padding: 11px 22px;
    border-radius: 4px;
    font-family: 'Lato', sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
    cursor: pointer;
    border: none;
}
.receipt-action-btn:hover { transform: translateY(-2px); }
</style>
@endpush

@section('content')
<div style="max-width:500px; margin:32px auto;">
    <div class="receipt-card">

        {{-- Top gold accent --}}
        <div style="height:4px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>

        <div style="padding:36px 32px; text-align:center;">

            {{-- Success Icon --}}
            <div style="
                width:76px; height:76px;
                background:linear-gradient(135deg,#1D4D30,#2D7A4F);
                border-radius:50%;
                display:flex; align-items:center; justify-content:center;
                margin:0 auto 20px;
                box-shadow:0 8px 28px rgba(45,122,79,0.3);
                animation: successPop 0.6s cubic-bezier(0.16,1,0.3,1);
            ">
                <i class="fa-solid fa-check" style="color:#fff; font-size:1.8rem;"></i>
            </div>

            {{-- Eyebrow --}}
            <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.28em; text-transform:uppercase; color:#C9A84C; margin-bottom:6px; animation:slideUp 0.5s ease 0.1s both;">Pesanan Dikonfirmasi</div>
            
            {{-- Title --}}
            <h1 style="font-family:'Playfair Display',serif; font-size:1.55rem; color:#0D0D0D; margin:0 0 6px; animation:slideUp 0.5s ease 0.15s both;">Pesanan Berhasil!</h1>
            <p style="font-family:'Cormorant Garamond',serif; color:#6B6560; font-size:1rem; margin-bottom:24px; animation:slideUp 0.5s ease 0.2s both;">
                Tunjukkan kode di bawah kepada kasir kami.
            </p>

            {{-- Transaction Code Box --}}
            <div style="
                background:linear-gradient(135deg,#111108,#1C1C17);
                border-radius:5px;
                padding:16px 20px;
                margin-bottom:24px;
                position:relative;
                overflow:hidden;
                animation:slideUp 0.5s ease 0.25s both;
            ">
                <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <div style="font-family:'Lato',sans-serif; font-size:0.6rem; letter-spacing:0.25em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:6px;">Kode Transaksi</div>
                {{-- DIPERKECIL: font-size dari 2rem → 1.25rem, tracking dikurangi --}}
                <div style="font-family:'Lato',sans-serif; font-size:1.2rem; font-weight:700; color:#C9A84C; letter-spacing:0.14em; animation:codeGlow 2.5s ease-in-out infinite;">{{ $transaction->transaction_code }}</div>
            </div>

            {{-- Order Details --}}
            <div style="text-align:left; margin-bottom:20px; animation:slideUp 0.5s ease 0.3s both;">
                <div class="receipt-row">
                    <span class="receipt-label">Nama Pemesan</span>
                    <span class="receipt-value">{{ $transaction->customer_name }}</span>
                </div>
                <div class="receipt-row">
                    <span class="receipt-label">Total Tagihan</span>
                    <div>
                        <span style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#8B6914; font-weight:700;">Rp</span>
                        <span style="font-family:'Playfair Display',serif; font-size:1.05rem; font-weight:700; color:#8B6914;">{{ number_format($transaction->final_total, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if($transaction->discount > 0)
                <div class="receipt-row">
                    <span class="receipt-label" style="color:#2D7A4F;"><i class="fa-solid fa-tag"></i> Diskon Member</span>
                    <span style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#2D7A4F;">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                @if($transaction->claimed_reward_name)
                <div class="receipt-row">
                    <span class="receipt-label" style="color:#1C7C54;"><i class="fa-solid fa-gift"></i> Hadiah Ditukar</span>
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:600; color:#1C7C54;">{{ $transaction->claimed_reward_name }}</span>
                </div>
                @endif
                <div class="receipt-row">
                    <span class="receipt-label">Status</span>
                    <span style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.08em; text-transform:uppercase;">Menunggu Pembayaran</span>
                </div>
            </div>

            {{-- Gold divider --}}
            <div style="display:flex; align-items:center; gap:12px; margin:16px 0; animation:slideUp 0.5s ease 0.35s both;">
                <div style="flex:1; height:1px; background:linear-gradient(to right, transparent, #E2D9CC);"></div>
                <span style="color:#C9A84C; font-size:0.9rem;">✦</span>
                <div style="flex:1; height:1px; background:linear-gradient(to left, transparent, #E2D9CC);"></div>
            </div>

            {{-- Actions --}}
            <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center; animation:slideUp 0.5s ease 0.4s both;">
                <a href="{{ route('home') }}" class="receipt-action-btn"
                   style="border:1.5px solid #E2D9CC; color:#6B6560;"
                   onmouseover="this.style.borderColor='#0D0D0D'; this.style.color='#0D0D0D'; this.style.background='#FAF7F2';"
                   onmouseout="this.style.borderColor='#E2D9CC'; this.style.color='#6B6560'; this.style.background='transparent';">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('catalog') }}" class="receipt-action-btn"
                   style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff;"
                   onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)';"
                   onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)';">
                    <i class="fa-solid fa-utensils"></i> Pesan Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection