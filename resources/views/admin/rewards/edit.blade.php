@extends('layouts.admin')
@section('page_title', 'Edit Hadiah')

@section('content')
<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:4px;">✦ &nbsp; Edit Hadiah</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#0D0D0D; margin:0;">Edit Hadiah: <em style="color:#8B6914;">{{ $reward->name }}</em></h1>
    </div>
    <a href="{{ route('admin.rewards.index') }}" style="border:1.5px solid #E2D9CC; color:#6B6560; text-decoration:none; padding:9px 18px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; display:inline-flex; align-items:center; gap:7px; transition:all 0.3s;" onmouseover="this.style.borderColor='#0D0D0D'; this.style.color='#0D0D0D';" onmouseout="this.style.borderColor='#E2D9CC'; this.style.color='#6B6560';">
        <i class="fa-solid fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
            <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
                <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;"><i class="fa-solid fa-pen" style="color:#C9A84C; margin-right:8px;"></i>Ubah Data Hadiah</span>
            </div>
            <div style="padding:28px;">
                <form action="{{ route('admin.rewards.update', $reward->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Nama Hadiah <span style="color:#6B2D3E;">*</span></label>
                            <input type="text" name="name" value="{{ $reward->name }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Playfair Display',serif; font-size:1rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        <div class="col-md-6">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Poin Dibutuhkan <span style="color:#6B2D3E;">*</span></label>
                            <input type="number" name="points_required" value="{{ $reward->points_required }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        <div class="col-md-6">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Stok Saat Ini <span style="color:#6B2D3E;">*</span></label>
                            <input type="number" name="stock" value="{{ $reward->stock }}"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.9rem; outline:none; transition:all 0.3s;" required
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        <div class="col-12">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Deskripsi Hadiah</label>
                            <textarea name="description" rows="3"
                                      style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Cormorant Garamond',serif; font-size:1rem; outline:none; transition:all 0.3s; resize:vertical;"
                                      onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                      onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">{{ $reward->description }}</textarea>
                        </div>
                        <div class="col-12">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Ganti Foto (Opsional)</label>
                            <input type="file" name="image" accept="image/*" id="imageUpload"
                                   style="width:100%; border:1px dashed #E2D9CC; border-radius:3px; padding:11px 14px; font-family:'Lato',sans-serif; font-size:0.85rem; cursor:pointer; background:#FAF7F2; outline:none;"
                                   onchange="previewImage(this)">
                        </div>
                        @if($reward->image_path)
                        <div class="col-12">
                            <div style="display:flex; gap:16px; flex-wrap:wrap; align-items:center;">
                                <div style="border:1px solid #E2D9CC; border-radius:3px; overflow:hidden; width:120px;">
                                    <img src="{{ asset('storage/' . $reward->image_path) }}" id="imgPreview" style="width:120px; height:80px; object-fit:cover; display:block;">
                                    <div style="padding:4px 8px; background:#FAF7F2; font-family:'Lato',sans-serif; font-size:0.68rem; color:#6B6560;">Foto saat ini</div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-12" id="imgPreviewWrap" style="display:none;">
                            <div style="border:1px solid #E2D9CC; border-radius:4px; overflow:hidden; max-width:260px;">
                                <img id="imgPreview" src="" alt="Preview" style="width:100%; height:160px; object-fit:cover;">
                                <div style="padding:8px 12px; background:#FAF7F2; font-family:'Lato',sans-serif; font-size:0.72rem; color:#6B6560;">Preview Gambar</div>
                            </div>
                        </div>
                        @endif

                        <div class="col-12">
                            <div style="display:flex; align-items:center; gap:12px; padding:12px; border:1px solid #E2D9CC; border-radius:3px; background:#FAF7F2;">
                                <label style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#0D0D0D; cursor:pointer; display:flex; align-items:center; gap:10px; margin:0;">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" {{ $reward->is_active ? 'checked' : '' }} style="accent-color:#C9A84C; width:18px; height:18px;">
                                    Status Hadiah Aktif
                                </label>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top:24px; padding-top:20px; border-top:1px solid #F0EAE0; display:flex; gap:12px; flex-wrap:wrap;">
                        <button type="submit" style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; border:none; padding:12px 28px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.06em; text-transform:uppercase; cursor:pointer; display:flex; align-items:center; gap:8px; transition:all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)';" onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)';">
                            <i class="fa-solid fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
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
            if(prev) {
                prev.src = e.target.result;
            } else {
                // If it was hidden previously
                document.getElementById('imgPreview').src = e.target.result;
                document.getElementById('imgPreviewWrap').style.display = 'block';
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
