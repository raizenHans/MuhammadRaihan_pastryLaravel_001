@extends('layouts.operator')

@section('page_title', 'Dashboard Operator')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase opacity-75 mb-2">Antrean Menunggu</h6>
                    <h2 class="fw-bold mb-0">5 Pesanan</h2>
                </div>
                <i class="fa-solid fa-hourglass-half fa-3x opacity-50"></i>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex align-items-center justify-content-center">
                 <a href="{{ route('operator.orders') }}" class="btn btn-warning btn-lg fw-bold w-75 py-3 shadow-sm">
                    <i class="fa-solid fa-cash-register me-2"></i> Buka Antrean Kasir
                </a>
            </div>
        </div>
    </div>
</div>
@endsection