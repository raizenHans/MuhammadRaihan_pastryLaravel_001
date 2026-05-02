@extends('layouts.operator')
@section('page_title', 'Dashboard Kasir')

@section('content')

<!-- Welcome -->
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:6px;">✦ &nbsp; Selamat Bertugas</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.7rem; color:#0D0D0D; margin:0;">Dashboard Kasir</h1>
        <p style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560; margin:4px 0 0;">Selamat datang, <strong>{{ Auth::user()->name }}</strong>. Kelola antrean dan stok harian di sini.</p>
    </div>
    <a href="{{ route('operator.orders') }}" style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; text-decoration:none; padding:11px 24px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; letter-spacing:0.06em; display:inline-flex; align-items:center; gap:8px; transition:all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)'; this.style.transform='translateY(-1px)';" onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)'; this.style.transform='translateY(0)';">
        <i class="fa-solid fa-cash-register"></i> Buka Kasir
    </a>
</div>

<!-- STAT CARDS -->
@php
    $pendingCount    = \App\Models\Transaction::where('payment_status','pending')->count();
    $todayDone       = \App\Models\Transaction::where('payment_status','lunas')->whereDate('created_at',today())->count();
    $todayRevenue    = \App\Models\Transaction::where('payment_status','lunas')->whereDate('created_at',today())->sum('final_total');
    $lowStockCount   = \App\Models\Pastry::where('stock','<',10)->count() + \App\Models\Drink::where('stock','<',10)->count();
    $totalRevenue    = \App\Models\Transaction::where('payment_status','lunas')->sum('final_total');
    $totalTrxCount   = \App\Models\Transaction::where('payment_status','lunas')->count();
    $monthRevenue    = \App\Models\Transaction::where('payment_status','lunas')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('final_total');
@endphp

<div class="row g-3 mb-4">
    <!-- Antrean Pending -->
    <div class="col-md-3">
        <div style="background:linear-gradient(135deg,#111108,#1C1C17); border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.1); transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#C9A84C,#8B6914);"></div>
            <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:10px;">Antrean Pending</div>
            <div style="font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:700; color:#C9A84C; line-height:1; {{ $pendingCount > 0 ? 'animation:pendingPulse 2s infinite;' : '' }}">{{ $pendingCount }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.4); margin-top:6px;">Belum dibayar</div>
        </div>
    </div>
    <!-- Selesai Hari Ini -->
    <div class="col-md-3">
        <div style="background:linear-gradient(135deg,#1D2E1A,#2D4A28); border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.1); transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#2D7A4F,#1C7C54);"></div>
            <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(100,200,100,0.6); margin-bottom:10px;">Selesai Hari Ini</div>
            <div style="font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:700; color:#7BC977; line-height:1;">{{ $todayDone }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.4); margin-top:6px;">Transaksi lunas</div>
        </div>
    </div>
    <!-- Revenue -->
    <div class="col-md-3">
        <div style="background:linear-gradient(135deg,#C9A84C,#8B6914); border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(201,168,76,0.3); transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(255,255,255,0.7); margin-bottom:10px;">Revenue Hari Ini</div>
            <div style="font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:700; color:#fff; line-height:1.2;">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.65); margin-top:6px;">Total pendapatan</div>
        </div>
    </div>
    <!-- Stok Menipis -->
    <div class="col-md-3">
        <div style="background:{{ $lowStockCount > 0 ? 'linear-gradient(135deg,#3A1A22,#5A2A35)' : 'linear-gradient(135deg,#1D2E1A,#2D4A28)' }}; border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.1); transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="position:absolute; top:0; left:0; right:0; height:3px; background:{{ $lowStockCount > 0 ? 'linear-gradient(90deg,#6B2D3E,#8B3D52)' : 'linear-gradient(90deg,#2D7A4F,#1C7C54)' }};"></div>
            <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:{{ $lowStockCount > 0 ? 'rgba(255,100,120,0.6)' : 'rgba(100,200,100,0.6)' }}; margin-bottom:10px;">Stok Menipis</div>
            <div style="font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:700; color:{{ $lowStockCount > 0 ? '#FF8A9B' : '#7BC977' }}; line-height:1;">{{ $lowStockCount }}</div>
            <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.4); margin-top:6px;">Produk stok &lt; 10</div>
        </div>
    </div>
</div>

<!-- REVENUE SUMMARY ROW -->
<div class="row g-3 mb-4">
    <!-- Total Revenue Keseluruhan -->
    <div class="col-md-4">
        <div style="background:linear-gradient(135deg,#1A0A2E,#2D1A4A); border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.1); border-left:4px solid #9B6BE8; transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(155,107,232,0.8); margin-bottom:8px;">Total Revenue Keseluruhan</div>
                    <div style="font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700; color:#C9A84C; line-height:1.2;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    <div style="font-family:'Lato',sans-serif; font-size:0.72rem; color:rgba(255,255,255,0.4); margin-top:6px;">{{ $totalTrxCount }} transaksi lunas total</div>
                </div>
                <div style="width:44px; height:44px; background:rgba(155,107,232,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-chart-line" style="color:#9B6BE8;"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Revenue Bulan Ini -->
    <div class="col-md-4">
        <div style="background:linear-gradient(135deg,#0A1E2E,#1A3A50); border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.1); border-left:4px solid #4A9EC9; transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(74,158,201,0.8); margin-bottom:8px;">Revenue Bulan Ini</div>
                    <div style="font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700; color:#5BC4F0; line-height:1.2;">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</div>
                    <div style="font-family:'Lato',sans-serif; font-size:0.72rem; color:rgba(255,255,255,0.4); margin-top:6px;">{{ now()->format('F Y') }}</div>
                </div>
                <div style="width:44px; height:44px; background:rgba(74,158,201,0.15); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-calendar-check" style="color:#4A9EC9;"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Rata-rata / Transaksi -->
    <div class="col-md-4">
        @php $avgTrx = $totalTrxCount > 0 ? round($totalRevenue / $totalTrxCount) : 0; @endphp
        <div style="background:linear-gradient(135deg,#1C1A08,#2E2A12); border-radius:6px; padding:20px; position:relative; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.1); border-left:4px solid #C9A84C; transition:transform 0.3s;" onmouseover="this.style.transform='translateY(-3px)';" onmouseout="this.style.transform='translateY(0)';">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.8); margin-bottom:8px;">Rata-rata per Transaksi</div>
                    <div style="font-family:'Playfair Display',serif; font-size:1.35rem; font-weight:700; color:#C9A84C; line-height:1.2;">Rp {{ number_format($avgTrx, 0, ',', '.') }}</div>
                    <div style="font-family:'Lato',sans-serif; font-size:0.72rem; color:rgba(255,255,255,0.4); margin-top:6px;">Nilai rata-rata order</div>
                </div>
                <div style="width:44px; height:44px; background:rgba(201,168,76,0.1); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-receipt" style="color:#C9A84C;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CHARTS + QUICK ACTIONS ROW -->
<div class="row g-4 mb-4">

    <!-- Transaksi Per Jam Chart -->
    <div class="col-lg-8">
        <div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
            <div style="padding:16px 20px; border-bottom:1px solid #F0EAE0; display:flex; justify-content:space-between; align-items:center;">
                <div style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#0D0D0D;"><i class="fa-solid fa-chart-line" style="color:#C9A84C; margin-right:8px;"></i>Transaksi Per Jam (Hari Ini)</div>
                <div id="live-date" style="font-family:'Lato',sans-serif; font-size:0.72rem; color:#6B6560;"></div>
            </div>
            <div style="padding:20px;">
                <div style="height:240px; position:relative;">
                    <canvas id="chartHourly"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- POS CTA -->
    <div class="col-lg-4">
        <div style="background:linear-gradient(135deg,#111108,#1C1C17); border-radius:6px; padding:32px 24px; text-align:center; height:100%; display:flex; flex-direction:column; justify-content:center; align-items:center; position:relative; overflow:hidden; box-shadow:0 4px 24px rgba(13,13,13,0.2);">
            <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
            <div style="position:absolute; right:-20px; bottom:-20px; font-size:8rem; color:rgba(201,168,76,0.04);"><i class="fa-solid fa-cash-register"></i></div>

            <div style="width:64px; height:64px; background:linear-gradient(135deg,#C9A84C,#8B6914); border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:20px; box-shadow:0 8px 24px rgba(201,168,76,0.3);">
                <i class="fa-solid fa-cash-register" style="color:#fff; font-size:1.5rem;"></i>
            </div>
            <div style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:600; color:#fff; margin-bottom:8px;">POS Pembayaran</div>
            <p style="font-family:'Lato',sans-serif; font-size:0.8rem; color:rgba(255,255,255,0.5); line-height:1.6; margin-bottom:24px;">Layani pembayaran pelanggan secara cepat dan akurat.</p>
            <a href="{{ route('operator.orders') }}" style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; text-decoration:none; padding:12px 28px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; display:flex; align-items:center; gap:8px; transition:all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg,#8B6914,#5A4008)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='linear-gradient(135deg,#C9A84C,#8B6914)'; this.style.transform='translateY(0)';">
                <i class="fa-solid fa-arrow-right"></i> Buka Antrean Kasir
            </a>
        </div>
    </div>
</div>

<!-- MENU CEPAT -->
<div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
    <div style="padding:16px 20px; border-bottom:1px solid #F0EAE0; background:linear-gradient(135deg,#0D0D0D,#1C1C17); position:relative;">
        <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
        <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;"><i class="fa-solid fa-bolt" style="color:#C9A84C; margin-right:8px;"></i>Update Stok & Inventori</span>
    </div>
    <div style="padding:16px; display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:12px;">
        @php
            $menus = [
                ['icon'=>'fa-bread-slice','label'=>'Update Stok Pastry','route'=>'admin.pastries.index','color'=>'#C9A84C'],
                ['icon'=>'fa-mug-hot','label'=>'Update Stok Minuman','route'=>'admin.drinks.index','color'=>'#1C7C54'],
                ['icon'=>'fa-tags','label'=>'Update Stok Promo','route'=>'admin.promos.index','color'=>'#6B2D3E'],
                ['icon'=>'fa-clock-rotate-left','label'=>'Riwayat Transaksi','route'=>'operator.history','color'=>'#1A4A8A'],
            ];
        @endphp
        @foreach($menus as $m)
        <a href="{{ route($m['route']) }}" style="
            display:flex; align-items:center; gap:12px;
            padding:14px 16px; border:1px solid #E2D9CC; border-radius:3px;
            text-decoration:none; color:#0D0D0D;
            transition:all 0.3s;
        "
        onmouseover="this.style.background='#F5EDD8'; this.style.borderColor='#C9A84C'; this.style.transform='translateX(4px)';"
        onmouseout="this.style.background='transparent'; this.style.borderColor='#E2D9CC'; this.style.transform='translateX(0)';">
            <div style="width:36px; height:36px; background:{{ $m['color'] }}18; border-radius:3px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <i class="fa-solid {{ $m['icon'] }}" style="color:{{ $m['color'] }};"></i>
            </div>
            <span style="font-family:'Lato',sans-serif; font-size:0.84rem; font-weight:700;">{{ $m['label'] }}</span>
            <i class="fa-solid fa-chevron-right ms-auto" style="color:#E2D9CC; font-size:0.65rem;"></i>
        </a>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Live date
    document.getElementById('live-date').textContent = new Date().toLocaleDateString('id-ID',{weekday:'long',year:'numeric',month:'long',day:'numeric'});

    // Hourly transaction data (PHP)
    @php
        // Ambil semua transaksi lunas hari ini, dikelompokkan per jam
        $transactionsByHour = \App\Models\Transaction::where('payment_status', 'lunas')
            ->whereDate('created_at', today())
            ->selectRaw('HOUR(created_at) as hour, count(*) as count')
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $hourlyData = [];
        $hourlyLabels = [];
        
        // Loop 24 jam untuk memastikan grafik lengkap
        for($h = 0; $h <= 23; $h++) {
            $hourlyLabels[] = sprintf('%02d:00', $h);
            $hourlyData[] = (int) ($transactionsByHour[$h] ?? 0);
        }
    @endphp

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js library is not loaded!');
            return;
        }

        const hourlyLabels = {!! json_encode($hourlyLabels) !!};
        const hourlyData   = {!! json_encode($hourlyData) !!};

        const ctxHourly = document.getElementById('chartHourly');
        if (ctxHourly) {
            new Chart(ctxHourly, {
                type: 'bar',
                data: {
                    labels: hourlyLabels,
                    datasets: [{
                        label: 'Transaksi Lunas',
                        data: hourlyData,
                        backgroundColor: 'rgba(201,168,76,0.2)',
                        borderColor: '#C9A84C',
                        borderWidth: 2,
                        borderRadius: 3,
                        hoverBackgroundColor: 'rgba(201,168,76,0.5)',
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { font:{size:10}, color:'#6B6560' } },
                        y: { grid:{color:'rgba(0,0,0,0.04)'}, ticks: { font:{size:10}, color:'#6B6560', stepSize:1 } }
                    }
                }
            });
        }
    });
</script>
@endpush
