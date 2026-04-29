@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Manajemen Member</h2>
    <a href="{{ route('admin.members.create') }}" class="btn btn-primary fw-bold"><i class="fa-solid fa-plus"></i> Tambah Member</a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm"><i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Kode Member</th>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Poin</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $m)
                <tr>
                    <td class="ps-4 fw-bold text-primary">{{ $m->member_code }}</td>
                    <td class="fw-bold">{{ $m->user->name }}</td>
                    <td>{{ $m->user->email }}</td>
                    <td>
                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-star"></i> {{ $m->points }} Poin</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.members.edit', $m->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen"></i> Edit</a>
                        <form action="{{ route('admin.members.destroy', $m->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus member ini?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i> Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
