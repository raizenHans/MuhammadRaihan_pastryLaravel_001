@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Tambah Staff Baru</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-bold"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Alamat Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Kata Sandi (Password)</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Hak Akses</label>
                <select name="role" class="form-select">
                    <option value="operator">Operator (Kasir)</option>
                    <option value="admin">Admin (Manager)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary fw-bold w-100 py-2"><i class="fa-solid fa-save"></i> Buat Akun</button>
        </form>
    </div>
</div>
@endsection
