@extends('layouts.admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Manajemen Staff / User</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary fw-bold"><i class="fa-solid fa-user-plus"></i> Tambah Staff</a>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm"><i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger border-0 shadow-sm"><i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4">Nama</th>
                    <th>Email</th>
                    <th>Hak Akses (Role)</th>
                    <th>Tanggal Bergabung</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td class="ps-4 fw-bold">
                        <i class="fa-solid fa-circle-user fa-lg me-2 text-secondary"></i> {{ $u->name }}
                    </td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->role === 'admin')
                            <span class="badge bg-danger"><i class="fa-solid fa-crown me-1"></i> Admin</span>
                        @else
                            <span class="badge bg-info text-dark"><i class="fa-solid fa-user-tie me-1"></i> Operator</span>
                        @endif
                    </td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-pen"></i></a>
                        @if($u->id !== Auth::id())
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus akun staff ini?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
