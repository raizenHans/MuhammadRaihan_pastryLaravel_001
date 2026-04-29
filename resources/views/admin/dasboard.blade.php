@extends('layouts.admin')
@section('page_title', 'Dashboard Admin')

@push('styles')
<style>
.stat-card {
    border: none;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13,13,13,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(13,13,13,0.14);
}
.stat-card .icon-bg {
    position: absolute;
    right: -12px; top: 50%;
    transform: translateY(-50%);
    font-size: 4rem;
    opacity: 0.12;
}
.chart-card {
    background: #fff;
    border: 1px solid #E2D9CC;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(13,13,13,0.06);
}
.chart-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #F0EAE0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chart-card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 600;
    color: #0D0D0D;
}
.chart-card-body { padding: 20px; }
</style>
@endpush

@section('content')

<!-- Welcome Row -->
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:6px;">✦ &nbsp; Selamat Datang Kembali</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.7rem; color:#0D0D0D; margin:0;">Dashboard Admin</h1>
        <p style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560; margin:4px 0 0;">Monitor performa bisnis Artorious Pastry secara real-time.</p>
    </div>
    <a href="{{ route('admin.pastries.create') }}" class="btn btn-gold d-flex align-items-center gap-2 px-4 py-2" style="border-radius:3px; font-size:0.82rem;">
        <i class="fa-solid fa-plus"></i> Tambah Produk
    </a>
</div>

<!-- ===== STAT CARDS ===== -->
<div class="row g-3 mb-4">
    @php
        $totalPastries = \App\Models\Pastry::count();
        $totalDrinks   = \App\Models\Drink::count();
        $totalPromos   = \App\Models\Promo::count();
        $totalProducts = $totalPastries + $totalDrinks + $totalPromos;
        $totalMembers  = \App\Models\Member::count();
        $todayRevenue  = \App\Models\Transaction::where('payment_status','lunas')->whereDate('created_at',today())->sum('final_total');
        $pendingOrders = \App\Models\Transaction::where('payment_status','pending')->count();
        $todayOrders   = \App\Models\Transaction::where('payment_status','lunas')->whereDate('created_at',today())->count();
        $lowStock      = \App\Models\Pastry::where('stock','<',10)->count() + \App\Models\Drink::where('stock','<',10)->count();
    @endphp

    <!-- Total Produk -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#111108,#1C1C17); color:#fff; padding:20px;">
            <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.7); margin-bottom:10px;">Total Produk</div>
            <div style="font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; color:#C9A84C; line-height:1;">{{ $totalProducts }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.45); margin-top:6px;">{{ $totalPastries }} Pastry &middot; {{ $totalDrinks }} Minuman &middot; {{ $totalPromos }} Promo</div>
            <i class="fa-solid fa-box icon-bg" style="color:#C9A84C;"></i>
        </div>
    </div>

    <!-- Total Member -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#1D2E1A,#2D4A28); color:#fff; padding:20px;">
            <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(100,200,100,0.7); margin-bottom:10px;">Total Member</div>
            <div style="font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; color:#7BC977; line-height:1;">{{ $totalMembers }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.45); margin-top:6px;">Pelanggan terdaftar</div>
            <i class="fa-solid fa-users icon-bg" style="color:#7BC977;"></i>
        </div>
    </div>

    <!-- Revenue Hari Ini -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; padding:20px;">
            <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.7); margin-bottom:10px;">Revenue Hari Ini</div>
            <div style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:700; color:#fff; line-height:1;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.65); margin-top:6px;">{{ $todayOrders }} transaksi lunas</div>
            <i class="fa-solid fa-money-bill-wave icon-bg" style="color:rgba(255,255,255,0.4);"></i>
        </div>
    </div>

    <!-- Stok Menipis -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background:{{ $lowStock > 0 ? 'linear-gradient(135deg,#3A1A22,#5A2A35)' : 'linear-gradient(135deg,#1D2E1A,#2D4A28)' }}; color:#fff; padding:20px;">
            <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,200,200,0.7); margin-bottom:10px;">Stok Menipis</div>
            <div style="font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; color:{{ $lowStock > 0 ? '#FF8A9B' : '#7BC977' }}; line-height:1;">{{ $lowStock }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.45); margin-top:6px;">Produk stok &lt; 10 pcs</div>
            <i class="fa-solid fa-triangle-exclamation icon-bg" style="color:{{ $lowStock > 0 ? '#FF8A9B' : '#7BC977' }};"></i>
        </div>
    </div>
</div>

<!-- ===== CHARTS ROW ===== -->
<div class="row g-4 mb-4">

    <!-- Revenue 7 Hari -->
    <div class="col-xl-8">
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-card-title"><i class="fa-solid fa-chart-line" style="color:#C9A84C; margin-right:8px;"></i>Revenue 7 Hari Terakhir</div>
                <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:#6B6560;">Transaksi lunas</div>
            </div>
            <div class="chart-card-body">
                <div style="height:260px; position:relative;">
                    <canvas id="chartRevenue"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Doughnut Komposisi Produk -->
    <div class="col-xl-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-card-title"><i class="fa-solid fa-chart-pie" style="color:#C9A84C; margin-right:8px;"></i>Komposisi Produk</div>
            </div>
            <div class="chart-card-body">
                <div style="height:220px; position:relative; display:flex; align-items:center; justify-content:center;">
                    <canvas id="chartComposition"></canvas>
                </div>
                <div style="display:flex; justify-content:center; gap:16px; margin-top:12px; flex-wrap:wrap;">
                    <span style="font-family:'Lato',sans-serif; font-size:0.72rem; display:flex; align-items:center; gap:5px;"><span style="width:10px; height:10px; border-radius:2px; background:#C9A84C; display:inline-block;"></span>Pastry</span>
                    <span style="font-family:'Lato',sans-serif; font-size:0.72rem; display:flex; align-items:center; gap:5px;"><span style="width:10px; height:10px; border-radius:2px; background:#1C7C54; display:inline-block;"></span>Minuman</span>
                    <span style="font-family:'Lato',sans-serif; font-size:0.72rem; display:flex; align-items:center; gap:5px;"><span style="width:10px; height:10px; border-radius:2px; background:#6B2D3E; display:inline-block;"></span>Promo</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== BOTTOM ROW ===== -->
<div class="row g-4">

    <!-- Top Produk (Bar Chart) -->
    <div class="col-xl-7">
        <div class="chart-card">
            <div class="chart-card-header">
                <div class="chart-card-title"><i class="fa-solid fa-chart-bar" style="color:#C9A84C; margin-right:8px;"></i>Produk Terlaris (Unit Terjual)</div>
                <span style="font-family:'Lato',sans-serif; font-size:0.72rem; background:#F5EDD8; color:#8B6914; padding:3px 8px; border-radius:2px; font-weight:700;">Bulan Ini</span>
            </div>
            <div class="chart-card-body">
                <div style="height:220px; position:relative;">
                    <canvas id="chartTopProducts"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-xl-5">
        <div class="chart-card h-100">
            <div class="chart-card-header">
                <div class="chart-card-title"><i class="fa-solid fa-bolt" style="color:#C9A84C; margin-right:8px;"></i>Aksi Cepat</div>
            </div>
            <div style="padding:16px; display:flex; flex-direction:column; gap:10px;">
                @php
                    $quickActions = [
                        ['icon'=>'fa-bread-slice','label'=>'Kelola Pastry','route'=>'admin.pastries.index','color'=>'#C9A84C'],
                        ['icon'=>'fa-mug-hot','label'=>'Kelola Minuman','route'=>'admin.drinks.index','color'=>'#1C7C54'],
                        ['icon'=>'fa-tags','label'=>'Kelola Promo','route'=>'admin.promos.index','color'=>'#6B2D3E'],
                        ['icon'=>'fa-gift','label'=>'Kelola Hadiah','route'=>'admin.rewards.index','color'=>'#8B6914'],
                        ['icon'=>'fa-users','label'=>'Data Pegawai','route'=>'admin.users.index','color'=>'#1A4A8A'],
                        ['icon'=>'fa-id-card','label'=>'Data Member','route'=>'admin.members.index','color'=>'#5A3A8A'],
                    ];
                @endphp
                @foreach($quickActions as $action)
                <a href="{{ route($action['route']) }}" style="
                    display:flex; align-items:center; gap:12px;
                    padding:12px 16px;
                    border:1px solid #E2D9CC; border-radius:3px;
                    text-decoration:none; color:#0D0D0D;
                    font-family:'Lato',sans-serif; font-size:0.84rem; font-weight:700;
                    transition:all 0.3s;
                "
                onmouseover="this.style.background='#F5EDD8'; this.style.borderColor='#C9A84C'; this.style.transform='translateX(4px)';"
                onmouseout="this.style.background='transparent'; this.style.borderColor='#E2D9CC'; this.style.transform='translateX(0)';">
                    <div style="width:32px; height:32px; background:{{ $action['color'] }}22; border-radius:3px; display:flex; align-items:center; justify-content:center;">
                        <i class="fa-solid {{ $action['icon'] }}" style="color:{{ $action['color'] }}; font-size:0.85rem;"></i>
                    </div>
                    {{ $action['label'] }}
                    <i class="fa-solid fa-chevron-right ms-auto" style="color:#E2D9CC; font-size:0.65rem;"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // ===== Data from PHP =====
    @php
        $last7Days = collect(range(6,0))->map(function($d) {
            $date = now()->subDays($d);
            return [
                'label' => $date->format('d M'),
                'value' => \App\Models\Transaction::where('payment_status','lunas')
                            ->whereDate('created_at',$date)->sum('final_total')
            ];
        });
        $topProducts = \App\Models\TransactionDetail::select('product_name', \DB::raw('SUM(quantity) as total_qty'))
                        ->groupBy('product_name')
                        ->orderByDesc('total_qty')
                        ->limit(5)
                        ->get();
    @endphp

    const revenueLabels = {!! json_encode($last7Days->pluck('label')) !!};
    const revenueData   = {!! json_encode($last7Days->pluck('value')) !!};
    const topLabels     = {!! json_encode($topProducts->pluck('product_name')) !!};
    const topData       = {!! json_encode($topProducts->pluck('total_qty')) !!};
    const composition   = [{{ $totalPastries }}, {{ $totalDrinks }}, {{ $totalPromos }}];

    // ===== Revenue Line Chart =====
    new Chart(document.getElementById('chartRevenue'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue (Rp)',
                data: revenueData,
                borderColor: '#C9A84C',
                backgroundColor: 'rgba(201,168,76,0.08)',
                borderWidth: 2.5,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#C9A84C',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: {size:11}, color:'#6B6560' } },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)' },
                    ticks: {
                        font: {size:11}, color:'#6B6560',
                        callback: v => 'Rp ' + Intl.NumberFormat('id-ID').format(v)
                    }
                }
            }
        }
    });

    // ===== Doughnut =====
    new Chart(document.getElementById('chartComposition'), {
        type: 'doughnut',
        data: {
            labels: ['Pastry', 'Minuman', 'Promo'],
            datasets: [{
                data: composition,
                backgroundColor: ['#C9A84C', '#1C7C54', '#6B2D3E'],
                borderColor: '#fff',
                borderWidth: 3,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            cutout: '65%'
        }
    });

    // ===== Bar Chart Top Products =====
    new Chart(document.getElementById('chartTopProducts'), {
        type: 'bar',
        data: {
            labels: topLabels.length ? topLabels : ['Belum Ada Data'],
            datasets: [{
                label: 'Unit Terjual',
                data: topData.length ? topData : [0],
                backgroundColor: 'rgba(201,168,76,0.15)',
                borderColor: '#C9A84C',
                borderWidth: 2,
                borderRadius: 3,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, indexAxis: 'y',
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { font:{size:11}, color:'#6B6560' } },
                y: { grid: { display: false }, ticks: { font:{size:11}, color:'#6B6560' } }
            }
        }
    });
</script>
@endpush