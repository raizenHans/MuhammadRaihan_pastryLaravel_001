@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Edit Data Staff</h2>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary fw-bold"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Alamat Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Kata Sandi Baru (Opsional)</label>
                <input type="password" name="password" class="form-control" minlength="6" placeholder="Abaikan jika tidak ingin mengubah password">
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Hak Akses</label>
                <select name="role" class="form-select">
                    <option value="operator" {{ $user->role === 'operator' ? 'selected' : '' }}>Operator (Kasir)</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin (Manager)</option>
                </select>
                @if($user->id === Auth::id())
                <div class="form-text text-danger mt-1"><i class="fa-solid fa-circle-info"></i> Berhati-hati mengubah role akun yang sedang Anda gunakan.</div>
                @endif
            </div>
            <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
