@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Edit Member</h2>
    <a href="{{ route('admin.members.index') }}" class="btn btn-outline-secondary fw-bold"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 600px;">
    <div class="card-body p-4">
        <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-bold">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $member->user->name }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="email" class="form-control" value="{{ $member->user->email }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Kode Member (Kartu)</label>
                <input type="text" class="form-control" value="{{ $member->member_code }}" disabled>
                <div class="form-text">Kode member tidak bisa diubah demi integritas data riwayat transaksi.</div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">NIK / KTP</label>
                <input type="text" name="nik" class="form-control" value="{{ $member->nik }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Nomor Handphone</label>
                <input type="text" name="phone" class="form-control" value="{{ $member->phone }}">
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Poin Awal</label>
                <input type="number" name="points" class="form-control" value="{{ $member->points }}" required>
            </div>
            <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2"><i class="fa-solid fa-save"></i> Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
