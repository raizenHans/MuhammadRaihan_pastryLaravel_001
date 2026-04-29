@extends('layouts.admin')
@section('page_title', 'Manajemen ' . ($category ?? 'Pastry'))

@section('content')

<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:4px;">✦ &nbsp; Inventori</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#0D0D0D; margin:0;">Manajemen {{ $category ?? 'Pastry' }}</h1>
    </div>
    @if(Auth::user()->role === 'admin')
    <a href="{{ route('admin.' . ($type ?? 'pastries') . '.create') }}" class="btn btn-gold d-flex align-items-center gap-2 px-4 py-2" style="border-radius:3px; font-size:0.82rem;">
        <i class="fa-solid fa-plus"></i> Tambah {{ $category ?? 'Pastry' }}
    </a>
    @endif
</div>

<!-- Table Card -->
<div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">

    <!-- Card Header -->
    <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; display:flex; align-items:center; justify-content:space-between; position:relative;">
        <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
        <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;">
            <i class="fa-solid fa-bread-slice" style="color:#C9A84C; margin-right:8px;"></i>
            Daftar {{ $category ?? 'Pastry' }}
        </span>
        <span style="font-family:'Lato',sans-serif; font-size:0.72rem; color:rgba(201,168,76,0.6);">
            {{ count($pastries) }} item
        </span>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table-classic" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="width:40px;"></th>
                    <th>Kode</th>
                    <th>Nama {{ $category ?? 'Produk' }}</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Status</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="sortableProductList">
                @forelse($pastries as $item)
                <tr data-id="{{ $item->id }}" data-type="{{ class_basename($item) }}">
                    <td style="color:#C9A84C; cursor:grab;" class="drag-handle"><i class="fa-solid fa-grip-vertical"></i></td>
                    <td>
                        <span style="font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; color:#6B6560; letter-spacing:0.06em;">{{ $item->product_code }}</span>
                    </td>
                    <td>
                        <span style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#0D0D0D;">{{ $item->name }}</span>
                    </td>
                    <td>
                        <span style="font-family:'Playfair Display',serif; font-size:0.9rem; color:#8B6914; font-weight:600;">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        @if($item->stock < 5)
                            <span style="background:linear-gradient(135deg,#5A2A35,#6B2D3E); color:#fff; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em; text-transform:uppercase;">{{ $item->stock }} — Kritis</span>
                        @elseif($item->stock < 10)
                            <span style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; font-family:'Lato',sans-serif; font-size:0.7rem; font-weight:700; padding:3px 10px; border-radius:2px; letter-spacing:0.06em; text-transform:uppercase;">{{ $item->stock }} — Menipis</span>
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
                        <a href="{{ route('admin.' . ($type ?? 'pastries') . '.edit', $item->id) }}" style="
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
                        @if(Auth::user()->role === 'admin')
                        <form action="{{ route('admin.' . ($type ?? 'pastries') . '.destroy', $item->id) }}" method="POST" class="d-inline">
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
                            onclick="return confirm('Yakin hapus produk ini?')">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding:60px 20px; text-align:center;">
                        <i class="fa-solid fa-box-open" style="font-size:3rem; color:#E2D9CC; display:block; margin-bottom:16px;"></i>
                        <div style="font-family:'Playfair Display',serif; font-size:1.1rem; color:#6B6560; margin-bottom:8px;">Belum ada data {{ $category ?? 'produk' }}</div>
                        @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.' . ($type ?? 'pastries') . '.create') }}" style="color:#8B6914; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; text-decoration:none;">
                            <i class="fa-solid fa-plus"></i> Tambah Sekarang
                        </a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortableProductList');
    if (el && el.querySelectorAll('tr[data-id]').length > 1) {
        new Sortable(el, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: async function () {
                let items = [];
                document.querySelectorAll('#sortableProductList tr[data-id]').forEach((tr, index) => {
                    items.push({
                        id: tr.dataset.id,
                        type: tr.dataset.type,
                        order: index + 1
                    });
                });

                try {
                    const res = await fetch('{{ route('admin.products.reorder') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': window.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ items: items })
                    });
                    const data = await res.json();
                    if (!data.success) {
                        alert(data.message || 'Gagal menyimpan urutan');
                    }
                } catch(e) {
                    console.error(e);
                }
            }
        });
    }
});
</script>
@endpush