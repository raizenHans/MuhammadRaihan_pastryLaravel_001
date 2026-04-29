@extends('layouts.operator')
@section('page_title', 'Riwayat Transaksi')

@push('styles')
<style>
.stat-mini {
    background: #fff;
    border: 1px solid #E2D9CC;
    border-radius: 6px;
    padding: 16px 20px;
    transition: transform 0.3s, box-shadow 0.3s;
}
.stat-mini:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(13,13,13,0.1);
}
</style>
@endpush

@section('content')

<!-- Header -->
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:4px;">✦ &nbsp; Laporan</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#0D0D0D; margin:0;">Riwayat Transaksi</h1>
        <p style="font-family:'Lato',sans-serif; font-size:0.8rem; color:#6B6560; margin:4px 0 0;">Kelola dan monitor semua pesanan pelanggan secara live.</p>
    </div>
</div>

<!-- Revenue Banner -->
<div style="background:linear-gradient(135deg,#111108,#1C1C17); border-radius:6px; padding:24px 28px; margin-bottom:24px; display:flex; justify-content:space-between; align-items:center; position:relative; overflow:hidden;">
    <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
    <div style="position:absolute; right:-20px; bottom:-20px; font-size:8rem; color:rgba(201,168,76,0.04);"><i class="fa-solid fa-chart-line"></i></div>
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:8px;">Total Pendapatan Lunas</div>
        <div id="totalRevenueBanner" style="font-family:'Playfair Display',serif; font-size:2.2rem; font-weight:700; color:#C9A84C; line-height:1.1;">
            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
        </div>
        <div style="font-family:'Lato',sans-serif; font-size:0.75rem; color:rgba(255,255,255,0.4); margin-top:6px;">Seluruh waktu — semua operator</div>
    </div>
    <div style="text-align:right;">
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.15em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:6px;">Revenue Hari Ini</div>
        <div id="statRevenueToday" style="font-family:'Playfair Display',serif; font-size:1.4rem; font-weight:700; color:#C9A84C;">Rp {{ number_format($stats['revenue_today'] ?? 0, 0, ',', '.') }}</div>
    </div>
</div>

<!-- Toast -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1055;">
    <div id="ajaxToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); border-left:4px solid #C9A84C !important; min-width:280px;">
        <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914);"></div>
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i id="toastIcon" class="fa-solid fa-check-circle" style="color:#C9A84C;"></i>
                <span id="toastMessage" style="font-family:'Lato',sans-serif; font-size:0.85rem;"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    @php
        $statCards = [
            ['title'=>'Total Pesanan',    'id'=>'statTotalOrders',      'val'=>$stats['total_orders'],  'color'=>'#C9A84C', 'icon'=>'fa-receipt'],
            ['title'=>'Pending',          'id'=>'statPendingOrders',     'val'=>$stats['pending_orders'],'color'=>'#E5950C', 'icon'=>'fa-clock'],
            ['title'=>'Diproses',         'id'=>'statProcessingOrders',  'val'=>$stats['processing_orders'],'color'=>'#1A6688','icon'=>'fa-gears'],
            ['title'=>'Selesai / Lunas',  'id'=>'statCompletedOrders',   'val'=>$stats['completed_orders'],'color'=>'#1C7C54','icon'=>'fa-check-circle'],
            ['title'=>'Dibatalkan',       'id'=>'statCancelledOrders',   'val'=>$stats['cancelled_orders'],'color'=>'#6B2D3E','icon'=>'fa-times-circle'],
        ];
    @endphp
    @foreach($statCards as $st)
    <div class="col-xl col-md-4 col-sm-6">
        <div class="stat-mini">
            <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px;">
                <div style="width:32px; height:32px; background:{{ $st['color'] }}18; border-radius:3px; display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid {{ $st['icon'] }}" style="color:{{ $st['color'] }}; font-size:0.85rem;"></i>
                </div>
                <span style="font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560;">{{ $st['title'] }}</span>
            </div>
            <div id="{{ $st['id'] }}" style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:700; color:{{ $st['color'] }};">{{ $st['val'] }}</div>
        </div>
    </div>
    @endforeach
</div>

<!-- Filter Panel -->
<div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; padding:20px; margin-bottom:20px; box-shadow:0 2px 12px rgba(13,13,13,0.04);">
    <div style="font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; margin-bottom:14px;"><i class="fa-solid fa-filter" style="color:#C9A84C; margin-right:6px;"></i>Filter Transaksi</div>
    <div class="row g-3 align-items-end">
        <div class="col-md-3">
            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:5px;">Cari Pelanggan</label>
            <input type="text" id="searchInput" placeholder="Nama / Kode Member..."
                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:10px 14px; font-family:'Lato',sans-serif; font-size:0.85rem; outline:none; transition:all 0.3s;"
                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.12)';"
                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
        </div>
        <div class="col-md-2">
            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:5px;">Status</label>
            <select id="statusSelect" style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:10px 14px; font-family:'Lato',sans-serif; font-size:0.85rem; outline:none; background:#fff;">
                <option value="">Semua</option>
                <option value="pending">Pending</option>
                <option value="diproses">Diproses</option>
                <option value="selesai">Selesai</option>
                <option value="dibatalkan">Dibatalkan</option>
            </select>
        </div>
        <div class="col-md-2">
            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:5px;">Pembayaran</label>
            <select id="paymentStatusSelect" style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:10px 14px; font-family:'Lato',sans-serif; font-size:0.85rem; outline:none; background:#fff;">
                <option value="">Semua</option>
                <option value="pending">Pending</option>
                <option value="lunas">Lunas</option>
                <option value="gagal">Gagal</option>
            </select>
        </div>
        <div class="col-md-3">
            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:5px;">Tanggal</label>
            <input type="date" id="dateInput" style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:10px 14px; font-family:'Lato',sans-serif; font-size:0.85rem; outline:none;">
        </div>
        <div class="col-md-2">
            <button type="button" id="btnFilter" style="width:100%; background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; border:none; padding:10px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; letter-spacing:0.06em; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:7px;">
                <i class="fa-solid fa-filter"></i> Terapkan
            </button>
        </div>
    </div>
</div>

<!-- Table Container -->
<div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
    <div id="ordersTableContainer">
        @include('operator.orders.partials.history_table', ['orders' => $orders])
    </div>
</div>

<!-- Delete Confirm Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content" style="border:none;border-radius:6px;overflow:hidden;box-shadow:0 24px 60px rgba(0,0,0,0.3);">
            <div style="background:linear-gradient(135deg,#3A1A22,#6B2D3E);padding:20px 24px;position:relative;">
                <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#FF6B8A,#6B2D3E,#FF6B8A);"></div>
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <h5 style="font-family:'Playfair Display',serif;color:#fff;margin:0;font-size:1.1rem;"><i class="fa-solid fa-trash" style="margin-right:10px;"></i>Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>
            <div style="padding:28px 24px;text-align:center;background:#fff;">
                <div style="width:64px;height:64px;background:linear-gradient(135deg,#FBF0F2,#F5D8DE);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="fa-solid fa-triangle-exclamation" style="color:#6B2D3E;font-size:1.5rem;"></i>
                </div>
                <h5 style="font-family:'Playfair Display',serif;margin-bottom:8px;">Hapus dari Riwayat?</h5>
                <p style="font-family:'Lato',sans-serif;color:#6B6560;font-size:0.85rem;margin-bottom:0;">Pesanan akan dihapus dari daftar riwayat. <strong>Total pendapatan tidak akan berkurang.</strong> Tindakan ini tidak dapat dibatalkan.</p>
                <input type="hidden" id="deleteOrderId">
            </div>
            <div style="padding:16px 24px 24px;display:flex;gap:10px;background:#fff;border-top:1px solid #F0EAE0;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="flex:0;border:1.5px solid #E2D9CC;color:#6B6560;background:transparent;border-radius:3px;font-family:'Lato',sans-serif;font-weight:700;padding:10px 20px;">Batal</button>
                <button type="button" id="btnConfirmDelete" style="flex:1;background:linear-gradient(135deg,#6B2D3E,#5A2A35);color:#fff;border:none;padding:11px;border-radius:3px;font-family:'Lato',sans-serif;font-size:0.85rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;">
                    <i class="fa-solid fa-trash"></i> Ya, Hapus
                </button>
            </div>
        </div>
    </div>
</div>


@endsection

@push('scripts')
{{-- Midtrans Snap.js --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const csrfToken = '{{ csrf_token() }}';
    let currentBankSelected = null;

    function showToast(message, type = 'success') {
        const toast = document.getElementById('ajaxToast');
        const icon  = document.getElementById('toastIcon');
        icon.className = type === 'success' ? 'fa-solid fa-check-circle' : 'fa-solid fa-circle-exclamation';
        icon.style.color = type === 'success' ? '#C9A84C' : '#FF8A9B';
        document.getElementById('toastMessage').innerText = message;
        new bootstrap.Toast(toast, {delay: 4000}).show();
    }

    function formatRupiah(num) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(num));
    }

    function updateStatsUI(stats, totalRevenue) {
        document.getElementById('statTotalOrders').innerText      = stats.total_orders;
        document.getElementById('statPendingOrders').innerText    = stats.pending_orders;
        document.getElementById('statProcessingOrders').innerText = stats.processing_orders;
        document.getElementById('statCompletedOrders').innerText  = stats.completed_orders;
        document.getElementById('statCancelledOrders').innerText  = stats.cancelled_orders;
        document.getElementById('statRevenueToday').innerText     = formatRupiah(stats.revenue_today);
        document.getElementById('totalRevenueBanner').innerText   = formatRupiah(totalRevenue);
    }

    // ── FILTER ──────────────────────────────────────────────
    function doFilter() {
        const btn = document.getElementById('btnFilter');
        const orig = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat...';
        btn.disabled = true;

        fetch('{{ route("operator.history.filter") }}', {
            method: 'POST',
            headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken,'Accept':'application/json'},
            body: JSON.stringify({
                search:         document.getElementById('searchInput').value,
                status:         document.getElementById('statusSelect').value,
                payment_status: document.getElementById('paymentStatusSelect').value,
                date:           document.getElementById('dateInput').value
            })
        }).then(r => r.json()).then(data => {
            if (data.success) {
                document.getElementById('ordersTableContainer').innerHTML = data.html;
                updateStatsUI(data.stats, data.total_revenue);
                showToast('Filter diterapkan — ' + data.count + ' transaksi ditemukan.');
            } else {
                showToast('Gagal memuat data.', 'danger');
            }
        }).catch(() => showToast('Gagal memuat data filter.', 'danger'))
          .finally(() => { btn.innerHTML = orig; btn.disabled = false; });
    }

    document.getElementById('btnFilter').addEventListener('click', doFilter);

    // Auto-filter saat dropdown berubah
    ['statusSelect','paymentStatusSelect'].forEach(id => {
        document.getElementById(id).addEventListener('change', doFilter);
    });

    // ── EVENT DELEGATION (table container) ──────────────────
    document.getElementById('ordersTableContainer').addEventListener('change', function(e) {
        if (e.target.classList.contains('select-order-status')) {
            changeOrderStatus(e.target.dataset.id, e.target.value);
        }
    });

    document.getElementById('ordersTableContainer').addEventListener('click', function(e) {
        const btnDel = e.target.closest('.btn-delete-order');
        if (btnDel) {
            document.getElementById('deleteOrderId').value = btnDel.dataset.id;
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    });

    function changeOrderStatus(id, status) {
        fetch('{{ route("operator.history.update.status") }}', {
            method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
            body: JSON.stringify({id_pemesanan: id, status})
        }).then(r => r.json()).then(d => {
            if (d.success) { showToast(d.message); updateStatsUI(d.stats, d.total_revenue); }
            else showToast(d.message, 'danger');
        });
    }

    // ── DELETE ───────────────────────────────────────────────
    document.getElementById('btnConfirmDelete').addEventListener('click', function() {
        const id  = document.getElementById('deleteOrderId').value;
        const btn = this;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Menghapus...';
        btn.disabled  = true;

        fetch('{{ route("operator.history.delete") }}', {
            method: 'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
            body: JSON.stringify({id_pemesanan: id})
        }).then(r => r.json()).then(d => {
            bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
            btn.innerHTML = '<i class="fa-solid fa-trash"></i> Ya, Hapus';
            btn.disabled  = false;
            if (d.success) {
                showToast(d.message);
                updateStatsUI(d.stats, d.total_revenue);
                const row = document.getElementById('order-row-' + id);
                if (row) { row.style.animation = 'fadeOut 0.3s ease forwards'; setTimeout(() => row.remove(), 300); }
            } else showToast(d.message, 'danger');
        });
    });


</script>

<style>
@keyframes fadeOut { to { opacity:0; transform:translateX(20px); } }
</style>
@endpush

