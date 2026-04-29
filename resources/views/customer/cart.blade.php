@extends('layouts.app')
@section('title', 'Keranjang Belanja — Artorious Pastry')

@section('content')
<div style="max-width: 900px; margin: 0 auto;" x-data='cartPage({
    initialItems: @json($cartItems),
    initialTotal: {{ $total }}
})'>

    <!-- Header -->
    <div style="margin-bottom: 28px;">
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:6px;">✦ &nbsp; Sebelum Checkout</div>
        <h1 style="font-family:'Playfair Display',serif; font-size:1.9rem; color:#0D0D0D; margin:0;">Keranjang Belanja</h1>
    </div>

    <div class="row g-4">
        <!-- Cart Items -->
        <div class="col-md-8">
            <div style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; overflow:hidden;">
                <!-- Card Header -->
                <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; display:flex; align-items:center; gap:10px; position:relative;">
                    <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                    <i class="fa-solid fa-basket-shopping" style="color:#C9A84C;"></i>
                    <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.85rem; letter-spacing:0.06em; text-transform:uppercase;">Detail Keranjang</span>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#FAF7F2; border-bottom:1px solid #E2D9CC;">
                                <th style="padding:12px 20px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560;">Produk</th>
                                <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560;">Harga</th>
                                <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; text-align:center;">Qty</th>
                                <th style="padding:12px 16px; font-family:'Lato',sans-serif; font-size:0.68rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560;">Subtotal</th>
                                <th style="padding:12px 16px; width:50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in items" :key="item.id">
                                <tr style="border-bottom:1px solid #E2D9CC; transition:background 0.2s;" :class="{'opacity-50': item.loading}">
                                    <td style="padding:16px 20px;">
                                        <div style="font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#0D0D0D;" x-text="item.product_name"></div>
                                    </td>
                                    <td style="padding:16px; font-family:'Lato',sans-serif; font-size:0.85rem; color:#6B6560;" x-text="'Rp ' + formatRupiah(item.price)"></td>
                                    <td style="padding:16px;">
                                        <!-- Numeric Stepper -->
                                        <div style="display:flex; align-items:center; justify-content:center; background:#F5EDD8; border:1px solid #E8D5A3; border-radius:4px; height:32px; width:85px; margin:0 auto;">
                                            <button @click="updateQty(item, parseInt(item.quantity) - 1)" :disabled="item.loading" style="background:none; border:none; color:#8B6914; width:28px; height:100%; cursor:pointer;"><i class="fa-solid" :class="item.quantity == 1 ? 'fa-trash-can' : 'fa-minus'"></i></button>
                                            <span style="font-family:'Lato',sans-serif; font-weight:700; color:#0D0D0D; padding:0 4px; min-width:24px; text-align:center;" x-text="item.quantity"></span>
                                            <button @click="updateQty(item, parseInt(item.quantity) + 1)" :disabled="item.loading" style="background:none; border:none; color:#8B6914; width:28px; height:100%; cursor:pointer;"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td style="padding:16px; font-family:'Playfair Display',serif; font-size:0.95rem; font-weight:600; color:#8B6914;" x-text="'Rp ' + formatRupiah(item.subtotal)"></td>
                                    <td style="padding:16px;">
                                        <button @click="removeItem(item)" :disabled="item.loading" style="background:transparent; border:1px solid #E2D9CC; color:#6B6560; padding:6px 10px; border-radius:3px; cursor:pointer; font-size:0.75rem;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            
                            <!-- Empty State -->
                            <tr x-show="items.length === 0">
                                <td colspan="5" style="padding:60px 20px; text-align:center;">
                                    <i class="fa-solid fa-basket-shopping" style="font-size:3rem; color:#E2D9CC; display:block; margin-bottom:16px;"></i>
                                    <div style="font-family:'Playfair Display',serif; font-size:1.1rem; color:#6B6560; margin-bottom:8px;">Keranjang Anda masih kosong</div>
                                    <a href="{{ route('catalog') }}" style="color:#8B6914; font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; text-decoration:none; letter-spacing:0.05em;">
                                        <i class="fa-solid fa-arrow-left"></i> Lihat Katalog
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div style="background:#fff; border:1px solid #E2D9CC; border-radius:4px; overflow:hidden; position:sticky; top:20px;">
                <div style="background:linear-gradient(135deg,#0D0D0D,#1C1C17); padding:14px 20px; position:relative;">
                    <div style="position:absolute; top:0; left:0; right:0; height:2px; background:linear-gradient(90deg,#C9A84C,#8B6914,#C9A84C);"></div>
                    <span style="font-family:'Lato',sans-serif; font-weight:700; color:#fff; font-size:0.82rem; letter-spacing:0.08em; text-transform:uppercase;">Ringkasan Pesanan</span>
                </div>
                <div style="padding:20px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #F0EAE0;">
                        <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560;">Total Item</span>
                        <span style="font-family:'Lato',sans-serif; font-weight:700; color:#0D0D0D;" x-text="items.reduce((s,i) => s + i.quantity, 0) + ' item'"></span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 0 12px; border-bottom:2px solid #E2D9CC; margin-bottom:12px;">
                        <span style="font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700; color:#0D0D0D; text-transform:uppercase; letter-spacing:0.05em;">Total Belanja</span>
                        <div>
                            <span style="font-family:'Lato',sans-serif; font-size:0.7rem; color:#8B6914; font-weight:700;">Rp</span>
                            <span style="font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:#8B6914;" x-text="formatRupiah(total)"></span>
                        </div>
                    </div>
                    <a :href="items.length > 0 ? '{{ route('checkout') }}' : '#'" class="d-block text-center" :style="items.length > 0 ? 'background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; cursor:pointer;' : 'background:#E2D9CC; color:#6B6560; pointer-events:none;'" style="
                        text-decoration:none; padding:13px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; transition:all 0.3s;
                    ">
                        <i class="fa-solid fa-check-double" style="margin-right:8px;"></i> Lanjut Checkout
                    </a>
                    <a href="{{ route('catalog') }}" style="display:block; text-align:center; margin-top:10px; color:#6B6560; font-family:'Lato',sans-serif; font-size:0.78rem; text-decoration:none;">
                        <i class="fa-solid fa-arrow-left"></i> Tambah Item Lain
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cartPage', (config) => ({
        items: config.initialItems.map(i => ({...i, loading: false})),
        total: config.initialTotal,

        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        },

        async updateQty(item, newQty) {
            if (newQty < 0 || item.loading) return;
            if (newQty === 0) { this.removeItem(item); return; }
            item.loading = true;

            try {
                const res = await fetch('{{ route('cart.ajax.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ cart_id: item.id, quantity: newQty })
                });
                const data = await res.json();
                if (data.success) {
                    item.quantity = data.newQty;
                    item.subtotal = data.newSubtotal;
                    this.recalcTotal();
                    updateCartBadge(data.cartCount);
                } else {
                    showCartToast(data.message || 'Gagal update keranjang', 'error');
                }
            } catch (e) {
                console.error(e);
                showCartToast('Terjadi kesalahan.', 'error');
            } finally {
                item.loading = false;
            }
        },

        async removeItem(item) {
            if (item.loading) return;
            item.loading = true;
            try {
                const res = await fetch('{{ route('cart.ajax.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ cart_id: item.id })
                });
                const data = await res.json();
                if (data.success) {
                    this.items = this.items.filter(i => i.id !== item.id);
                    this.recalcTotal();
                    updateCartBadge(data.cartCount);
                }
            } catch (e) {
                console.error(e);
            }
            item.loading = false;
        },

        recalcTotal() {
            this.total = this.items.reduce((s, i) => s + parseFloat(i.subtotal || 0), 0);
        }
    }));
});
</script>
@endpush