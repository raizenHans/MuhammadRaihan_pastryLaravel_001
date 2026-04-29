@extends('layouts.app')
@section('title', 'Pesanan Berhasil — Artorious Pastry')

@section('content')
<div style="max-width:520px; margin:40px auto;">
    <div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 8px 40px rgba(13,13,13,0.08);">

        <!-- Top accent -->
        <div style="height:4px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>

        <div style="padding:40px 36px; text-align:center;">

            <!-- Success Icon -->
            <div style="
                width:80px; height:80px;
                background:linear-gradient(135deg,#1D4D30,#2D7A4F);
                border-radius:50%;
                display:flex; align-items:center; justify-content:center;
                margin:0 auto 24px;
                box-shadow:0 8px 24px rgba(45,122,79,0.3);
                animation: successPop 0.5s cubic-bezier(0.68,-0.55,0.265,1.55);
            ">
                <i class="fa-solid fa-check" style="color:#fff; font-size:2rem;"></i>
            </div>

            <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:8px;">Pesanan Dikonfirmasi</div>
            <h1 style="font-family:'Playfair Display',serif; font-size:1.7rem; color:#0D0D0D; margin:0 0 8px;">Pesanan Berhasil Dibuat!</h1>
            <p style="font-family:'Cormorant Garamond',serif; color:#6B6560; font-size:1.05rem; margin-bottom:28px;">
                Tunjukkan kode di bawah kepada kasir kami untuk melakukan pembayaran.
            </p>

            <!-- Transaction Code Box -->
            <div style="
                background:linear-gradient(135deg,#111108,#1C1C17);
                border-radius:4px;
                padding:20px 24px;
                margin-bottom:28px;
                position:relative;
                overflow:hidden;
            ">
                <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.25em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:8px;">Kode Transaksi</div>
                <div style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:700; color:#C9A84C; letter-spacing:0.08em;">{{ $transaction->transaction_code }}</div>
            </div>

            <!-- Order Details -->
            <div style="text-align:left; margin-bottom:24px;">
                <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0EAE0;">
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560;">Nama Pemesan</span>
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#0D0D0D;">{{ $transaction->customer_name }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0EAE0;">
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560;">Total Tagihan</span>
                    <div>
                        <span style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#8B6914; font-weight:700;">Rp</span>
                        <span style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:#8B6914;">{{ number_format($transaction->final_total, 0, ',', '.') }}</span>
                    </div>
                </div>
                @if($transaction->discount > 0)
                <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0EAE0;">
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#2D7A4F; display:flex; align-items:center; gap:6px;"><i class="fa-solid fa-tag"></i> Diskon Member</span>
                    <span style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#2D7A4F;">- Rp {{ number_format($transaction->discount, 0, ',', '.') }}</span>
                </div>
                @endif
                @if($transaction->claimed_reward_name)
                <div style="display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #F0EAE0;">
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#1C7C54; display:flex; align-items:center; gap:6px;"><i class="fa-solid fa-gift"></i> Hadiah Ditukar</span>
                    <span style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#1C7C54;">{{ $transaction->claimed_reward_name }}</span>
                </div>
                @endif
                <div style="display:flex; justify-content:space-between; padding:10px 0;">
                    <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560;">Status</span>
                    <span style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.08em; text-transform:uppercase;">Menunggu Pembayaran</span>
                </div>
            </div>

            <!-- Gold divider -->
            <div style="display:flex; align-items:center; gap:12px; margin:20px 0;">
                <div style="flex:1; height:1px; background:linear-gradient(to right, transparent, #E2D9CC);"></div>
                <span style="color:#C9A84C; font-size:1rem;">✦</span>
                <div style="flex:1; height:1px; background:linear-gradient(to left, transparent, #E2D9CC);"></div>
            </div>

            <!-- Actions -->
            <div style="display:flex; gap:12px; flex-wrap:wrap; justify-content:center;">
                <a href="{{ route('home') }}" style="
                    border:1.5px solid #E2D9CC; color:#6B6560; text-decoration:none;
                    padding:11px 20px; border-radius:3px;
                    font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700;
                    letter-spacing:0.05em; display:inline-flex; align-items:center; gap:6px;
                    transition:all 0.3s;
                "
                onmouseover="this.style.borderColor='#0D0D0D'; this.style.color='#0D0D0D';"
                onmouseout="this.style.borderColor='#E2D9CC'; this.style.color='#6B6560';">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="{{ route('catalog') }}" style="
                    background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; text-decoration:none;
                    padding:11px 20px; border-radius:3px;
                    font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700;
                    letter-spacing:0.05em; display:inline-flex; align-items:center; gap:6px;
                    transition:all 0.3s;
                "
                onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)'; this.style.transform='translateY(-1px)';"
                onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)'; this.style.transform='translateY(0)';">
                    <i class="fa-solid fa-utensils"></i> Pesan Lagi
                </a>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes successPop {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}
</style>
@endsection