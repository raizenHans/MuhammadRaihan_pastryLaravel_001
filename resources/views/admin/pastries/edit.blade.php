@extends('layouts.admin')
@section('page_title', 'Edit ' . ($title ?? 'Pastry'))

@section('content')
<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:4px;">✦ &nbsp; Edit Produk</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#0D0D0D; margin:0;">Edit {{ $title ?? 'Pastry' }}: <em style="color:#8B6914;">{{ $pastry->name }}</em></h1>
    </div>
    <a href="{{ route('admin.' . ($type ?? 'pastries') . '.index') }}" style="border:1.5px solid #E2D9CC; color:#6B6560; text-decoration:none; padding:9px 18px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; display:inline-flex; align-items:center; gap:7px; transition:all 0.3s;" onmouseover="this.style.borderColor='#0D0D0D'; this.style.color='#0D0D0D';" onmouseout="this.style.borderColor='#E2D9CC'; this.style.color='#6B6560';">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
            <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
                <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;"><i class="fa-solid fa-pen" style="color:#C9A84C; margin-right:8px;"></i>Ubah Data Produk</span>
            </div>
            <div style="padding:28px;">
                <form action="{{ route('admin.' . ($type ?? 'pastries') . '.update', $pastry->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    @if(Auth::user()->role !== 'admin')
                    <!-- Operator info box -->
                    <div style="background:#F5EDD8; border:1px solid #E2D9CC; border-left:4px solid #C9A84C; border-radius:3px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:flex-start; gap:10px;">
                        <i class="fa-solid fa-circle-info" style="color:#C9A84C; margin-top:2px;"></i>
                        <div style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#0D0D0D;">
                            <strong>Mode Operator:</strong> Anda hanya dapat mengubah Stok, Harga, dan Status Aktif dari produk
                            <strong>{{ $pastry->name }} ({{ $pastry->product_code }})</strong>.
                        </div>
                    </div>
                    @endif

                    <div class="row g-3">
                        @if(Auth::user()->role === 'admin')
                        <div class="col-md-6">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Kode Produk</label>
                            <input type="text" name="product_code" value="{{ $pastry->product_code }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; background:#FAF7F2; color:#6B6560; cursor:not-allowed;"
                                   readonly tabindex="-1">
                        </div>
                        <div class="col-md-6">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Nomor Urutan</label>
                            <input type="number" name="product_number" value="{{ $pastry->product_number }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        <div class="col-12">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Nama {{ $title ?? 'Pastry' }}</label>
                            <input type="text" name="name" value="{{ $pastry->name }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Playfair Display',serif; font-size:1rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        @endif

                        <div class="col-md-6">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ floor($pastry->price) }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        <div class="col-md-6">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Stok Saat Ini</label>
                            <input type="number" name="stock" value="{{ $pastry->stock }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>

                        @if(Auth::user()->role === 'admin')
                        <div class="col-12">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Deskripsi</label>
                            <textarea name="description" rows="3"
                                      style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Cormorant Garamond',serif; font-size:1rem; outline:none; transition:all 0.3s; resize:vertical;"
                                      onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                      onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">{{ $pastry->description }}</textarea>
                        </div>
                        <div class="col-12">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Ganti Foto (Opsional)</label>
                            <input type="file" name="image" accept="image/*" id="imageUpload"
                                   style="width:100%; border:1px dashed #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.85rem; cursor:pointer; background:#FAF7F2; outline:none;"
                                   onchange="previewImage(this)">
                        </div>
                        @if($pastry->image_path)
                        <div class="col-12">
                            <div style="display:flex; gap:16px; flex-wrap:wrap; align-items:center;">
                                <div style="border:1px solid #E2D9CC; border-radius:3px; overflow:hidden; width:120px;">
                                    <img src="{{ asset('storage/' . $pastry->image_path) }}" id="imgPreview" style="width:120px; height:80px; object-fit:cover; display:block;">
                                    <div style="padding:4px 8px; background:#FAF7F2; font-family:'Lato',sans-serif; font-size:0.68rem; color:#6B6560;">Foto saat ini</div>
                                </div>
                                <div style="font-family:'Lato',sans-serif; font-size:0.78rem; color:#6B6560; max-width:200px;">
                                    Pilih file baru untuk mengganti foto yang sudah ada.
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif

                        <div class="col-12">
                            <div style="display:flex; align-items:center; gap:12px; padding:12px; border:1px solid #E2D9CC; border-radius:3px; background:#FAF7F2;">
                                <label style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#0D0D0D; cursor:pointer; display:flex; align-items:center; gap:10px; margin:0;">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $pastry->is_active ? 'checked' : '' }} style="accent-color:#C9A84C; width:18px; height:18px;">
                                    Status Produk Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:24px; padding-top:20px; border-top:1px solid #F0EAE0; display:flex; gap:12px; flex-wrap:wrap; justify-content:space-between; align-items:center;">
                        <button type="submit" style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; border:none; padding:12px 28px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; cursor:pointer; display:flex; align-items:center; gap:8px; transition:all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)';" onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)';">
                            <i class="fa-solid fa-save"></i> Simpan Perubahan
                        </button>
                        
                        @if(Auth::user()->role === 'admin')
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalChangeCategory" style="background:transparent; color:#6B2D3E; border:1px solid #6B2D3E; padding:10px 20px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.8rem; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; cursor:pointer; display:flex; align-items:center; gap:8px; transition:all 0.3s;" onmouseover="this.style.background='#FBF0F2';" onmouseout="this.style.background='transparent';">
                            <i class="fa-solid fa-exchange-alt"></i> Pindah Kategori
                        </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="col-lg-4">
        <div style="background:#FAF7F2; border:1px solid #E2D9CC; border-radius:6px; padding:20px; margin-bottom:16px;">
            <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.15em; text-transform:uppercase; color:#C9A84C; margin-bottom:8px;">Info Produk</div>
            <table style="width:100%; font-family:'Lato',sans-serif; font-size:0.82rem;">
                <tr>
                    <td style="color:#6B6560; padding:4px 0;">Kode</td>
                    <td style="font-weight:700; color:#0D0D0D;">{{ $pastry->product_code }}</td>
                </tr>
                <tr>
                    <td style="color:#6B6560; padding:4px 0;">Stok Saat Ini</td>
                    <td style="font-weight:700; color:{{ $pastry->stock < 10 ? '#6B2D3E' : '#1C7C54' }};">{{ $pastry->stock }} pcs</td>
                </tr>
                <tr>
                    <td style="color:#6B6560; padding:4px 0;">Dibuat</td>
                    <td style="font-weight:700; color:#0D0D0D;">{{ optional($pastry->created_at)->format('d M Y') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pindah Kategori -->
<div class="modal fade" id="modalChangeCategory" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content" style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; box-shadow:0 12px 40px rgba(13,13,13,0.15);">
            <div class="modal-header" style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); border-bottom:1px solid #E2D9CC; position:relative; padding:16px 20px;">
                <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <h5 class="modal-title" style="font-family:'Playfair Display',serif; color:#fff; font-size:1.1rem;"><i class="fa-solid fa-exchange-alt" style="color:#C9A84C; margin-right:8px;"></i>Pindah Kategori</h5>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="padding:20px; background:#FAF7F2;">
                <p style="font-family:'Lato',sans-serif; font-size:0.85rem; color:#6B6560; margin-bottom:16px;">
                    Produk <strong style="color:#0D0D0D;">{{ $pastry->name }}</strong> saat ini berada di kategori <strong style="color:#0D0D0D;">{{ class_basename($pastry) }}</strong>. Pilih kategori tujuan di bawah ini.
                </p>
                <form id="formChangeCategory">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $pastry->id }}">
                    <input type="hidden" name="source_type" value="{{ class_basename($pastry) }}">
                    
                    <select name="target_type" style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:10px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; margin-bottom:20px;" required>
                        <option value="" disabled selected>-- Pilih Kategori Tujuan --</option>
                        <option value="Pastry">Pastry</option>
                        <option value="Drink">Minuman (Drink)</option>
                        <option value="Promo">Promo Combo</option>
                    </select>

                    <button type="button" onclick="submitChangeCategory()" style="width:100%; background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; border:none; padding:10px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; cursor:pointer; transition:all 0.3s;">
                        Pindahkan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewImage(input) {
    if(input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const prev = document.getElementById('imgPreview');
            if(prev) prev.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

async function submitChangeCategory() {
    const form = document.getElementById('formChangeCategory');
    const formData = new FormData(form);
    const targetType = formData.get('target_type');

    if (!targetType) return alert('Pilih kategori tujuan!');
    if (targetType === formData.get('source_type')) return alert('Kategori tujuan sama dengan kategori saat ini.');

    try {
        const res = await fetch('{{ route('admin.products.change-category') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        });
        const data = await res.json();
        if (data.success) {
            alert(data.message);
            // Redirect based on target category list
            if (targetType === 'Pastry') window.location.href = '{{ route('admin.pastries.index') }}';
            else if (targetType === 'Drink') window.location.href = '{{ route('admin.drinks.index') }}';
            else if (targetType === 'Promo') window.location.href = '{{ route('admin.promos.index') }}';
        } else {
            alert(data.message || 'Terjadi kesalahan');
        }
    } catch(e) {
        console.error(e);
        alert('Gagal menghubungi server.');
    }
}
</script>
@endpush
