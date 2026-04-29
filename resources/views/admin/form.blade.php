@extends('layouts.admin')

@section('content')
<div class="d-flex align-items-center mb-4">
    <a href="{{ route('admin.pastries.index') }}" class="btn btn-outline-dark me-3"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
    <h2 class="fw-bold m-0">{{ isset($pastry) ? 'Edit Pastry: '.$pastry->name : 'Tambah Pastry Baru' }}</h2>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form action="{{ isset($pastry) ? route('admin.pastries.update', $pastry->id) : route('admin.pastries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($pastry)) @method('PUT') @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $pastry->name ?? '') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-bold">Nomor Urut <span class="text-danger">*</span></label>
                    <input type="number" name="product_number" class="form-control" value="{{ old('product_number', $pastry->product_number ?? '') }}" placeholder="Contoh: 1" required>
                    <small class="text-muted">Untuk PSTR00(X)</small>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Harga (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control" value="{{ old('price', $pastry->price ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Stok Awal <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $pastry->stock ?? '0') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Deskripsi Singkat</label>
                <textarea name="description" class="form-control" rows="3">{{ old('description', $pastry->description ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Status Aktif</label>
                <select name="is_active" class="form-select w-25">
                    <option value="1" {{ old('is_active', $pastry->is_active ?? 1) == 1 ? 'selected' : '' }}>Aktif (Tampil di Katalog)</option>
                    <option value="0" {{ old('is_active', $pastry->is_active ?? 1) == 0 ? 'selected' : '' }}>Nonaktif (Sembunyikan)</option>
                </select>
            </div>

            <button type="submit" class="btn btn-dark btn-lg fw-bold"><i class="fa-solid fa-save"></i> Simpan Data</button>
        </form>
    </div>
</div>
@endsection