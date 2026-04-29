@extends('layouts.admin')
@section('page_title', 'Manajemen Hadiah (Reward)')

@section('content')

<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:4px;">✦ &nbsp; Member Loyalty</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#0D0D0D; margin:0;">Manajemen Hadiah</h1>
    </div>
    <a href="{{ route('admin.rewards.create') }}" class="btn btn-gold d-flex align-items-center gap-2 px-4 py-2" style="border-radius:3px; font-size:0.82rem;">
        <i class="fa-solid fa-gift"></i> Tambah Hadiah Baru
    </a>
</div>

<!-- Table Card -->
<div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
    <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; display:flex; align-items:center; justify-content:space-between; position:relative;">
        <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
        <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;">
            <i class="fa-solid fa-gift" style="color:#C9A84C; margin-right:8px;"></i>
            Katalog Hadiah
        </span>
        <span style="font-family:'Lato',sans-serif; font-size:0.72rem; color:rgba(201,168,76,0.6);">
            {{ count($rewards) }} item
        </span>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table-classic" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Hadiah</th>
                    <th>Poin Dibutuhkan</th>
                    <th>Stok Tersedia</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rewards as $item)
                <tr>
                    <td>
                        @if($item->image_path)
                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" style="width:50px; height:50px; object-fit:cover; border-radius:3px; border:1px solid #E2D9CC;">
                        @else
                            <div style="width:50px; height:50px; background:#F5EDD8; display:flex; align-items:center; justify-content:center; border-radius:3px; color:#C9A84C;">
                                <i class="fa-solid fa-gem"></i>
                            </div>
                        @endif
                    </td>
                    <td>
                        <span style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#0D0D0D;">{{ $item->name }}</span>
                    </td>
                    <td>
                        <span style="display:inline-block; background:#F5EDD8; color:#8B6914; padding:3px 10px; border-radius:12px; font-family:'Lato',sans-serif; font-size:0.75rem; font-weight:700;">
                            <i class="fa-solid fa-star" style="font-size:0.65rem; margin-right:4px;"></i> {{ number_format($item->points_required, 0, ',', '.') }} Ptg
                        </span>
                    </td>
                    <td>
                        @if($item->stock < 5 && $item->stock > 0)
                            <span style="background:linear-gradient(135deg,#5A2A35,#6B2D3E); color:#fff; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em; text-transform:uppercase;">{{ $item->stock }} — Kritis</span>
                        @elseif($item->stock == 0)
                            <span style="background:#E2D9CC; color:#6B6560; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em; text-transform:uppercase;">Habis</span>
                        @else
                            <span style="background:linear-gradient(135deg,#1C7C54,#1D4D30); color:#fff; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em; text-transform:uppercase;">{{ $item->stock }} Pcs</span>
                        @endif
                    </td>
                    <td>
                        @if($item->is_active)
                            <span style="background:rgba(28,124,84,0.12); color:#1C7C54; border:1px solid rgba(28,124,84,0.3); font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em;">Aktif</span>
                        @else
                            <span style="background:rgba(107,101,96,0.1); color:#6B6560; border:1px solid rgba(107,101,96,0.25); font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="text-align:center; white-space:nowrap;">
                        <a href="{{ route('admin.rewards.edit', $item->id) }}" style="
                            border:1.5px solid #C9A84C; color:#8B6914;
                            padding:5px 12px; border-radius:3px; text-decoration:none;
                            font-family:'Lato',sans-serif; font-size:0.75rem; font-weight:700;
                            display:inline-flex; align-items:center; gap:5px; margin-right:4px;
                            transition:all 0.25s;
                        "
                        onmouseover="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)'; this.style.color='#fff';"
                        onmouseout="this.style.background='transparent'; this.style.color='#8B6914';">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.rewards.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" style="
                                border:1.5px solid rgba(107,45,62,0.4); color:#6B2D3E;
                                background:transparent; padding:5px 12px; border-radius:3px;
                                font-family:'Lato',sans-serif; font-size:0.75rem; font-weight:700;
                                display:inline-flex; align-items:center; gap:5px; cursor:pointer;
                                transition:all 0.25s;
                            "
                            onmouseover="this.style.background='linear-gradient(135deg,#5A2A35,#6B2D3E)'; this.style.color='#fff'; this.style.borderColor='#6B2D3E';"
                            onmouseout="this.style.background='transparent'; this.style.color='#6B2D3E'; this.style.borderColor='rgba(107,45,62,0.4)';"
                            onclick="return confirm('Yakin hapus hadiah ini?')">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:60px 20px; text-align:center;">
                        <i class="fa-solid fa-gift" style="font-size:3rem; color:#E2D9CC; display:block; margin-bottom:16px;"></i>
                        <div style="font-family:'Playfair Display',serif; font-size:1.1rem; color:#6B6560; margin-bottom:8px;">Belum ada data hadiah</div>
                        <a href="{{ route('admin.rewards.create') }}" style="color:#8B6914; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; text-decoration:none;">
                            <i class="fa-solid fa-plus"></i> Tambah Hadiah Baru
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
