@extends('layouts.app')
@section('title', 'Riwayat Pesanan — Artorious Pastry')

@section('content')
<!-- Header -->
<div style="margin-bottom:28px; text-align:center;">
    <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; color:#C9A84C; margin-bottom:8px;">✦ &nbsp; Riwayat Anda &nbsp; ✦</div>
    <h1 style="font-family:'Playfair Display',serif; font-size:1.9rem; color:#0D0D0D; margin:0 0 8px;">Riwayat Pesanan</h1>
    <p style="font-family:'Cormorant Garamond',serif; color:#6B6560; font-size:1rem;">Pantau status pesanan dan dapatkan struk pembelian Anda di sini.</p>
</div>

<div style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; overflow:hidden;">
    <!-- Header Card -->
    <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
        <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
        <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;"><i class="fa-solid fa-clock-rotate-left" style="color:#C9A84C; margin-right:8px;"></i>Daftar Transaksi</span>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#FAF7F2;">
                    <th style="padding:12px 20px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; border-bottom:1px solid #E2D9CC;">No. Transaksi</th>
                    <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; border-bottom:1px solid #E2D9CC;">Tanggal</th>
                    <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; border-bottom:1px solid #E2D9CC;">Total</th>
                    <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; border-bottom:1px solid #E2D9CC;">Status</th>
                    <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; border-bottom:1px solid #E2D9CC; text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Simulasi UI — akan dihubungkan ke data nyata -->
                <tr style="border-bottom:1px solid #F0EAE0; transition:background 0.2s;" onmouseover="this.style.background='#F5EDD8'" onmouseout="this.style.background='transparent'">
                    <td style="padding:14px 20px;">
                        <span style="font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; color:#0D0D0D;">TRX20260416999</span>
                    </td>
                    <td style="padding:14px 16px; font-family:'Lato',sans-serif; font-size:0.85rem; color:#6B6560;">16 Apr 2026</td>
                    <td style="padding:14px 16px; font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#8B6914;">Rp 150.000</td>
                    <td style="padding:14px 16px;">
                        <span style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; padding:4px 10px; border-radius:2px;">Menunggu Bayar</span>
                    </td>
                    <td style="padding:14px 16px; text-align:center;">
                        <a href="#" style="
                            border:1.5px solid #E2D9CC; color:#6B6560;
                            text-decoration:none; padding:6px 14px; border-radius:3px;
                            font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700;
                            letter-spacing:0.04em; transition:all 0.3s; display:inline-block;
                        "
                        onmouseover="this.style.borderColor='#C9A84C'; this.style.color='#8B6914';"
                        onmouseout="this.style.borderColor='#E2D9CC'; this.style.color='#6B6560';">
                            Detail
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="padding:40px 20px; text-align:center;">
                        <div style="height:1px; background:linear-gradient(90deg,transparent,#E2D9CC,transparent); margin-bottom:24px;"></div>
                        <i class="fa-solid fa-receipt" style="font-size:2.5rem; color:#E2D9CC; display:block; margin-bottom:12px;"></i>
                        <div style="font-family:'Cormorant Garamond',serif; font-size:1rem; color:#6B6560;">Transaksi Anda akan tampil di sini setelah melakukan pemesanan.</div>
                        <a href="{{ route('catalog') }}" style="display:inline-flex; align-items:center; gap:6px; margin-top:16px; background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; text-decoration:none; padding:10px 20px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.8rem; font-weight:700; letter-spacing:0.06em;">
                            <i class="fa-solid fa-utensils"></i> Pesan Sekarang
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
