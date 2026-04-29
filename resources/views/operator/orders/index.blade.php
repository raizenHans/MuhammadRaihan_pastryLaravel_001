@extends('layouts.operator')
@section('page_title', 'Antrean Kasir')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <div>
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:4px;">✦ &nbsp; Sistem Kasir</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#0D0D0D; margin:0;">
            <i class="fa-solid fa-cash-register" style="color:#C9A84C;"></i> Antrean Kasir
        </h1>
    </div>
    <span style="background:{{ count($pendingOrders) > 0 ? 'linear-gradient(135deg,#C9A84C,#8B6914)' : 'linear-gradient(135deg,#1C7C54,#1D4D30)' }}; color:#fff; font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; padding:6px 14px; border-radius:3px;">
        {{ count($pendingOrders) > 0 ? count($pendingOrders).' transaksi menunggu' : 'Antrean Kosong ✓' }}
    </span>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert" style="border-radius:4px; border-left:4px solid #1C7C54;">
    <i class="fa-solid fa-check-circle" style="color:#1C7C54"></i>
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert" style="border-radius:4px; border-left:4px solid #6B2D3E;">
    <i class="fa-solid fa-circle-exclamation" style="color:#6B2D3E"></i>
    <span>{{ session('error') }}</span>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
</div>
@endif

<div style="background:#fff; border:1px solid #E2D9CC; border-radius:6px; overflow:hidden; box-shadow:0 2px 12px rgba(13,13,13,0.06);">
    <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
        <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
        <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;">
            <i class="fa-solid fa-list" style="color:#C9A84C; margin-right:8px;"></i>Pesanan Menunggu Pembayaran
        </span>
    </div>
    <div class="table-responsive">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#FAF7F2;">
                    @foreach(['Waktu','Kode Transaksi','Pelanggan','Total','Status','Bayar'] as $h)
                    <th style="padding:12px 16px{{ $loop->first ? ' 12px 20px' : '' }}; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; border-bottom:1px solid #E2D9CC;{{ $loop->last ? ' text-align:center;':'' }}">{{ $h }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($pendingOrders as $order)
                <tr style="border-bottom:1px solid #F0EAE0; transition:background 0.2s;" onmouseover="this.style.background='#F5EDD8'" onmouseout="this.style.background='transparent'">
                    <td style="padding:14px 16px 14px 20px; font-family:'Lato',sans-serif; font-size:0.8rem; color:#6B6560;">
                        {{ $order->created_at->format('H:i') }}<br>
                        <span style="font-size:0.72rem; opacity:0.7;">{{ $order->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td style="padding:14px 16px;">
                        <span style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#0D0D0D;">{{ $order->transaction_code }}</span>
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-family:'Playfair Display',serif; font-size:0.9rem; color:#0D0D0D;">{{ $order->customer_name }}</div>
                        @if($order->member_id)
                        <span style="background:rgba(28,124,84,0.1); color:#1C7C54; border:1px solid rgba(28,124,84,0.25); font-size:0.65rem; font-weight:700; padding:2px 8px; border-radius:2px;">Member</span>
                        @endif
                    </td>
                    <td style="padding:14px 16px;">
                        <div style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:700; color:#8B6914;">Rp {{ number_format($order->final_total, 0, ',', '.') }}</div>
                        @if($order->discount > 0)
                        <div style="font-size:0.7rem; color:#1C7C54;"><i class="fa-solid fa-tag"></i> Diskon: Rp {{ number_format($order->discount, 0, ',', '.') }}</div>
                        @endif
                    </td>
                    <td style="padding:14px 16px;">
                        <span style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; font-size:0.68rem; font-weight:700; padding:4px 10px; border-radius:2px; text-transform:uppercase;">Menunggu ⏳</span>
                    </td>
                    <td style="padding:14px 16px; text-align:center;">
                        <button onclick="openKasirPay({{ $order->id }}, {{ $order->final_total }}, '{{ addslashes($order->transaction_code) }}', '{{ addslashes($order->customer_name) }}')"
                                style="background:linear-gradient(135deg,#1C7C54,#1D4D30); color:#fff; border:none; padding:8px 16px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.3s;"
                                onmouseover="this.style.background='linear-gradient(135deg,#1D4D30,#0D2A1A)';" onmouseout="this.style.background='linear-gradient(135deg,#1C7C54,#1D4D30)';">
                            <i class="fa-solid fa-money-bill-wave"></i> Bayar Lunas
                        </button>
                    </td>
                </tr>

                {{-- Pre-rendered items HTML per order (digunakan modal) --}}
                <template id="order-items-{{ $order->id }}">
                    @foreach($order->details as $d)
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0EAE0;">
                        <div>
                            <div style="font-family:'Playfair Display',serif; font-size:0.9rem; color:#0D0D0D;">{{ $d->product_name }}</div>
                            <div style="font-size:0.75rem; color:#6B6560;">{{ $d->quantity }} × Rp {{ number_format($d->unit_price, 0, ',', '.') }}</div>
                        </div>
                        <div style="font-weight:700; color:#8B6914; font-size:0.85rem;">Rp {{ number_format($d->final_subtotal, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                    @if($order->discount > 0)
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0EAE0;">
                        <span style="color:#1C7C54; font-size:0.82rem;"><i class="fa-solid fa-tag"></i> Diskon Member</span>
                        <span style="color:#1C7C54; font-weight:700;">- Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                </template>
                @empty
                <tr>
                    <td colspan="6" style="padding:60px 20px; text-align:center;">
                        <i class="fa-solid fa-circle-check" style="font-size:3rem; color:#1C7C54; display:block; margin-bottom:12px; opacity:0.5;"></i>
                        <div style="font-family:'Playfair Display',serif; font-size:1.1rem; color:#6B6560;">Tidak ada antrean saat ini</div>
                        <div style="font-family:'Lato',sans-serif; font-size:0.8rem; color:#9E9690; margin-top:4px;">Semua pesanan sudah diproses ✓</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== SINGLE SHARED PAYMENT MODAL ===== --}}
<div class="modal fade" id="kasirPayModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
        <div class="modal-content" style="border:none; border-radius:6px; overflow:hidden; box-shadow:0 24px 60px rgba(0,0,0,0.35);">

            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:20px 24px; position:relative;">
                <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <div style="font-family:'Lato',sans-serif; font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:4px;">Proses Pembayaran</div>
                        <h5 id="kasirModalCode" style="font-family:'Playfair Display',serif; color:#fff; font-size:1.1rem; margin:0;"></h5>
                        <div id="kasirModalCustomer" style="font-family:'Lato',sans-serif; font-size:0.78rem; color:rgba(255,255,255,0.5); margin-top:4px;"></div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
            </div>

            {{-- Body --}}
            <div style="padding:24px; background:#fff;">

                {{-- Items list --}}
                <div id="kasirModalItems" style="margin-bottom:16px;"></div>

                {{-- Total Box --}}
                <div style="background:linear-gradient(135deg,#111108,#1C1C17); border-radius:3px; padding:14px 16px; margin-bottom:20px; display:flex; justify-content:space-between; align-items:center; position:relative; overflow:hidden;">
                    <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                    <span style="font-family:'Lato',sans-serif; font-size:0.75rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:rgba(255,255,255,0.6);">Total Tagihan</span>
                    <span id="kasirDisplayTotal" style="font-family:'Playfair Display',serif; font-size:1.5rem; font-weight:700; color:#C9A84C;"></span>
                </div>

                {{-- STEP 1: Pilih Metode --}}
                <div id="kasirStep1">
                    <div style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; margin-bottom:12px;">Pilih Metode Pembayaran</div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <button onclick="kasirShowCash()" style="border:2px solid #E2D9CC; border-radius:4px; padding:20px 12px; background:#fff; cursor:pointer; transition:all 0.3s; text-align:center;"
                                onmouseover="this.style.borderColor='#1C7C54'; this.style.background='#F0F7F4';" onmouseout="this.style.borderColor='#E2D9CC'; this.style.background='#fff';">
                            <i class="fa-solid fa-money-bill-wave" style="font-size:2rem; color:#1C7C54; display:block; margin-bottom:8px;"></i>
                            <div style="font-family:'Lato',sans-serif; font-weight:700; font-size:0.85rem; color:#0D0D0D;">Tunai</div>
                            <div style="font-size:0.72rem; color:#6B6560;">Cash</div>
                        </button>
                        <button onclick="kasirShowQris()" style="border:2px solid #E2D9CC; border-radius:4px; padding:20px 12px; background:#fff; cursor:pointer; transition:all 0.3s; text-align:center;"
                                onmouseover="this.style.borderColor='#C9A84C'; this.style.background='#F5EDD8';" onmouseout="this.style.borderColor='#E2D9CC'; this.style.background='#fff';">
                            <i class="fa-solid fa-credit-card" style="font-size:2rem; color:#C9A84C; display:block; margin-bottom:8px;"></i>
                            <div style="font-family:'Lato',sans-serif; font-weight:700; font-size:0.85rem; color:#0D0D0D;">VA / QRIS / Online</div>
                            <div style="font-size:0.72rem; color:#6B6560;">via Midtrans</div>
                        </button>
                    </div>
                </div>

                {{-- STEP 2A: Cash --}}
                <div id="kasirStep2Cash" style="display:none;">
                    <button onclick="kasirStep(1)" style="background:none; border:none; color:#C9A84C; font-size:0.78rem; font-weight:700; cursor:pointer; margin-bottom:12px; padding:0;">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </button>
                    <form id="kasirCashForm" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="Cash">
                        <input type="hidden" name="paid_amount" id="kasirPaidHidden">
                        <div style="margin-bottom:14px;">
                            <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.1em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:6px;">Uang Diterima (Rp)</label>
                            <input type="number" id="kasirPaidInput" placeholder="0" oninput="kasirCalcChange()"
                                   style="width:100%; border:1px solid #E2D9CC; border-radius:3px; padding:12px 14px; font-family:'Playfair Display',serif; font-size:1.1rem; outline:none; transition:all 0.3s;"
                                   onfocus="this.style.borderColor='#C9A84C'; this.style.boxShadow='0 0 0 3px rgba(201,168,76,0.15)';"
                                   onblur="this.style.borderColor='#E2D9CC'; this.style.boxShadow='none';">
                        </div>
                        <div id="kasirChangeBox" style="background:#F0F7F4; border:1px solid #1C7C54; border-left:4px solid #2D7A4F; border-radius:3px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                            <span style="font-family:'Lato',sans-serif; font-size:0.78rem; font-weight:700; color:#1C7C54; text-transform:uppercase;"><i class="fa-solid fa-hand-holding-dollar"></i> Kembalian</span>
                            <span id="kasirChangeVal" style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:#1C7C54;">Rp 0</span>
                        </div>
                        <button type="button" id="btnKasirCash" onclick="kasirSubmitCash()" disabled
                                style="width:100%; background:linear-gradient(135deg,#1C7C54,#1D4D30); color:#fff; border:none; padding:12px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px; opacity:0.5;">
                            <i class="fa-solid fa-check-double"></i> Selesaikan Transaksi
                        </button>
                    </form>
                </div>

                {{-- STEP 2B: QRIS / Midtrans --}}
                <div id="kasirStep2Qris" style="display:none;">
                    <button onclick="kasirStep(1)" style="background:none; border:none; color:#C9A84C; font-size:0.78rem; font-weight:700; cursor:pointer; margin-bottom:16px; padding:0;">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </button>
                    <div style="text-align:center; padding:10px 0 20px;">
                        <i class="fa-solid fa-qrcode" style="font-size:3rem; color:#C9A84C; margin-bottom:12px; display:block;"></i>
                        <div style="font-family:'Playfair Display',serif; font-size:1rem; color:#0D0D0D; margin-bottom:6px;">Pembayaran QRIS / E-Wallet</div>
                        <div style="font-family:'Lato',sans-serif; font-size:0.78rem; color:#6B6560; margin-bottom:20px;">Klik tombol di bawah untuk membuka halaman pembayaran Midtrans</div>
                        <button id="btnKasirQris" onclick="kasirStartQris()"
                                style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; border:none; padding:13px 24px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:all 0.3s;">
                            <i class="fa-solid fa-mobile-screen-button"></i> Buka Pembayaran Midtrans
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
const kasirCsrf = '{{ csrf_token() }}';
let kasirOrderId, kasirTotal;

function openKasirPay(id, total, code, customer) {
    kasirOrderId = id;
    kasirTotal   = total;
    document.getElementById('kasirModalCode').textContent     = code;
    document.getElementById('kasirModalCustomer').textContent = customer;
    document.getElementById('kasirDisplayTotal').textContent  = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);

    // Load items from pre-rendered template
    const tpl = document.getElementById('order-items-' + id);
    document.getElementById('kasirModalItems').innerHTML = tpl ? tpl.innerHTML : '';

    kasirStep(1);
    new bootstrap.Modal(document.getElementById('kasirPayModal')).show();
}

function kasirStep(step) {
    document.getElementById('kasirStep1').style.display      = step === 1      ? 'block' : 'none';
    document.getElementById('kasirStep2Cash').style.display  = step === 'cash' ? 'block' : 'none';
    document.getElementById('kasirStep2Qris').style.display  = step === 'qris' ? 'block' : 'none';
}

function kasirShowCash() {
    document.getElementById('kasirPaidInput').value = '';
    document.getElementById('kasirChangeVal').textContent = 'Rp 0';
    document.getElementById('btnKasirCash').disabled = true;
    document.getElementById('btnKasirCash').style.opacity = '0.5';
    kasirStep('cash');
}

function kasirShowQris() { kasirStep('qris'); }

function kasirCalcChange() {
    const paid   = parseFloat(document.getElementById('kasirPaidInput').value) || 0;
    const change = paid - kasirTotal;
    const box    = document.getElementById('kasirChangeBox');
    const val    = document.getElementById('kasirChangeVal');
    const btn    = document.getElementById('btnKasirCash');
    if (change >= 0) {
        val.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
        val.style.color = '#1C7C54';
        box.style.background = '#F0F7F4'; box.style.borderColor = '#1C7C54'; box.style.borderLeftColor = '#2D7A4F';
        btn.disabled = false; btn.style.opacity = '1';
    } else {
        val.textContent = 'Kurang Rp ' + new Intl.NumberFormat('id-ID').format(-change);
        val.style.color = '#6B2D3E';
        box.style.background = '#FBF0F2'; box.style.borderColor = '#6B2D3E'; box.style.borderLeftColor = '#6B2D3E';
        btn.disabled = true; btn.style.opacity = '0.5';
    }
}

function kasirSubmitCash() {
    document.getElementById('kasirPaidHidden').value = document.getElementById('kasirPaidInput').value;
    const form = document.getElementById('kasirCashForm');
    form.action = '{{ url("operator/orders") }}/' + kasirOrderId + '/pay';
    form.submit();
}

function kasirStartQris() {
    const btn = document.getElementById('btnKasirQris');
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat...';

    fetch('{{ route("operator.history.generate.snap") }}', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': kasirCsrf,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ id_pemesanan: kasirOrderId, bank: 'Online' })
    })
    .then(async r => {
        const text = await r.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            console.error("Midtrans response error:", text);
            throw new Error("Invalid JSON response from server: " + text.substring(0, 100));
        }
    })
    .then(d => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-mobile-screen-button"></i> Buka Pembayaran Midtrans';

        if (!d.success) { alert('Gagal: ' + d.message); return; }

        bootstrap.Modal.getInstance(document.getElementById('kasirPayModal')).hide();

        snap.pay(d.snap_token, {
            onSuccess: function(result) {
                fetch('{{ route("operator.orders.midtrans.success") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': kasirCsrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ order_id: d.order_id })
                }).then(r => r.json()).then(r2 => {
                    if (r2.success) { alert('Pembayaran QRIS berhasil! Transaksi selesai.'); location.reload(); }
                    else { alert('Pembayaran diterima tapi gagal validasi: ' + r2.message); location.reload(); }
                });
            },
            onPending: function() { alert('Menunggu pembayaran dari pelanggan.'); },
            onError:   function() { alert('Pembayaran gagal.'); },
            onClose:   function() { /* Transaksi masih pending, biarkan di antrean */ }
        });
    })
    .catch((e) => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-mobile-screen-button"></i> Buka Pembayaran Midtrans';
        alert('Gagal menghubungi Midtrans: ' + (e.message || 'Error tidak diketahui'));
    });
}
</script>

<style>
@keyframes pendingPulse { 0%,100%{opacity:1} 50%{opacity:0.6} }
</style>
@endpush