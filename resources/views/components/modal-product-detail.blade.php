<!-- Modal Product Detail — Classical European Design + Image Bug Fix -->
<div class="modal fade" id="modalProductDetail" tabindex="-1"
     aria-labelledby="modalProductDetailLabel" aria-hidden="true"
     x-data="productModal()"
     @open-product-modal.window="loadProduct($event.detail)">

    <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
        <div class="modal-content" style="
            border: none;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 24px 60px rgba(0,0,0,0.35);
        ">
            <form @submit.prevent="addToCart()">

                <!-- Modal Header -->
                <div class="modal-header border-0" style="
                    background: linear-gradient(135deg, #0D0D0D 0%, #1C1C17 100%);
                    padding: 20px 24px;
                    position: relative;
                ">
                    <!-- Gold top accent line -->
                    <div style="position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg, #C9A84C, #8B6914, #C9A84C);"></div>

                    <div>
                        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:4px;" x-text="product.category || 'Menu Kami'"></div>
                        <h5 class="modal-title" id="modalProductDetailLabel" x-text="product.name"
                            style="font-family:'Playfair Display',serif; color:#fff; font-size:1.3rem; font-weight:600; margin:0;"></h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Product Image -->
                <div style="height:220px; overflow:hidden; position:relative; background:#F5EDD8;">
                    <!-- Show actual image if available -->
                    <template x-if="product.image_path">
                        <img :src="'/storage/' + product.image_path"
                             :alt="product.name"
                             style="width:100%; height:220px; object-fit:cover; display:block; transition:opacity 0.4s;"
                             x-ref="productImg">
                    </template>
                    <!-- Placeholder if no image -->
                    <template x-if="!product.image_path">
                        <div style="width:100%; height:220px; display:flex; align-items:center; justify-content:center; background:linear-gradient(135deg,#F5EDD8,#E8D5A3);">
                            <div style="text-align:center;">
                                <i class="fa-solid fa-croissant" style="font-size:4rem; color:#C9A84C; opacity:0.5;"></i>
                                <div style="font-family:'Cormorant Garamond',serif; color:#8B6914; font-size:0.9rem; margin-top:8px; opacity:0.7;">Artorious Pastry</div>
                            </div>
                        </div>
                    </template>
                    <!-- Gold gradient overlay at bottom -->
                    <div style="position:absolute; bottom:0; left:0; right:0; height:60px; background:linear-gradient(to top, rgba(245,237,216,0.8), transparent);"></div>
                </div>

                <!-- Modal Body -->
                <div class="modal-body" style="padding:24px; background:#fff;">

                    <!-- Price -->
                    <div style="display:flex; align-items:baseline; gap:4px; margin-bottom:20px;">
                        <span style="font-family:'Lato',sans-serif; font-size:0.75rem; color:#8B6914; font-weight:700;">Rp</span>
                        <span x-text="new Intl.NumberFormat('id-ID').format(product.price)"
                              style="font-family:'Playfair Display',serif; font-size:1.6rem; color:#8B6914; font-weight:700;"></span>
                    </div>

                    <!-- Divider -->
                    <div style="height:1px; background:linear-gradient(90deg,transparent,#E2D9CC,transparent); margin-bottom:20px;"></div>

                    <!-- Quantity Control -->
                    <div style="margin-bottom:16px;">
                        <label style="font-family:'Lato',sans-serif; font-size:0.72rem; font-weight:700; letter-spacing:0.12em; text-transform:uppercase; color:#6B6560; display:block; margin-bottom:10px;">Jumlah Pesanan</label>
                        <div style="display:flex; align-items:center; gap:0;">
                            <button type="button"
                                    @click="if(quantity > 1) quantity--"
                                    style="
                                        width:40px; height:40px;
                                        background:var(--noir, #0D0D0D); color:#C9A84C;
                                        border:none; border-radius:3px 0 0 3px;
                                        font-size:1rem; cursor:pointer;
                                        display:flex; align-items:center; justify-content:center;
                                        transition:background 0.2s;
                                    "
                                    onmouseover="this.style.background='#C9A84C'; this.style.color='#0D0D0D';"
                                    onmouseout="this.style.background='#0D0D0D'; this.style.color='#C9A84C';">
                                <i class="fa-solid fa-minus" style="font-size:0.75rem;"></i>
                            </button>
                            <input type="number" name="quantity"
                                   x-model="quantity"
                                   min="1" readonly
                                   style="
                                       width:60px; height:40px;
                                       text-align:center;
                                       border:1px solid #E2D9CC; border-left:none; border-right:none;
                                       font-family:'Playfair Display',serif;
                                       font-size:1.1rem; font-weight:600;
                                       color:#0D0D0D;
                                       background:#FAF7F2;
                                       outline:none;
                                   ">
                            <button type="button"
                                    @click="quantity++"
                                    style="
                                        width:40px; height:40px;
                                        background:var(--noir, #0D0D0D); color:#C9A84C;
                                        border:none; border-radius:0 3px 3px 0;
                                        font-size:1rem; cursor:pointer;
                                        display:flex; align-items:center; justify-content:center;
                                        transition:background 0.2s;
                                    "
                                    onmouseover="this.style.background='#C9A84C'; this.style.color='#0D0D0D';"
                                    onmouseout="this.style.background='#0D0D0D'; this.style.color='#C9A84C';">
                                <i class="fa-solid fa-plus" style="font-size:0.75rem;"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Subtotal -->
                    <div style="
                        background:#F5EDD8;
                        border:1px solid #E2D9CC;
                        border-radius:3px;
                        padding:12px 16px;
                        display:flex;
                        justify-content:space-between;
                        align-items:center;
                    ">
                        <span style="font-family:'Lato',sans-serif; font-size:0.82rem; color:#6B6560; font-weight:700; letter-spacing:0.05em;">TOTAL</span>
                        <div style="display:flex; align-items:baseline; gap:3px;">
                            <span style="font-family:'Lato',sans-serif; font-size:0.75rem; color:#8B6914; font-weight:700;">Rp</span>
                            <span x-text="new Intl.NumberFormat('id-ID').format(product.price * quantity)"
                                  style="font-family:'Playfair Display',serif; font-size:1.25rem; color:#8B6914; font-weight:700;"></span>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer border-0" style="padding:16px 24px 24px; background:#fff; gap:10px;">
                    <button type="button" class="btn" data-bs-dismiss="modal"
                            style="
                                border:1.5px solid #E2D9CC; color:#6B6560;
                                background:transparent; padding:10px 20px;
                                font-family:'Lato',sans-serif; font-size:0.82rem; font-weight:700;
                                border-radius:3px; letter-spacing:0.05em;
                                transition:all 0.3s; flex:0;
                            "
                            onmouseover="this.style.borderColor='#0D0D0D'; this.style.color='#0D0D0D';"
                            onmouseout="this.style.borderColor='#E2D9CC'; this.style.color='#6B6560';">
                        Batal
                    </button>
                    <button type="submit" style="
                        flex:1;
                        background:linear-gradient(135deg, #C9A84C, #8B6914);
                        color:#fff; border:none;
                        padding:11px 20px;
                        font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700;
                        letter-spacing:0.06em; text-transform:uppercase;
                        border-radius:3px; cursor:pointer;
                        display:flex; align-items:center; justify-content:center; gap:8px;
                        transition:all 0.3s;
                    "
                    onmouseover="this.style.background='linear-gradient(135deg, #8B6914, #5A4008)'; this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(201,168,76,0.4)';"
                    onmouseout="this.style.background='linear-gradient(135deg, #C9A84C, #8B6914)'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fa-solid fa-basket-shopping"></i>
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function productModal() {
        return {
            product: { id: '', name: '', price: 0, type: '', image_path: null, category: 'Menu' },
            quantity: 1,
            loading: false,
            loadProduct(data) {
                this.product = data;
                this.quantity = 1;
            },
            async addToCart() {
                if (this.loading) return;
                this.loading = true;

                try {
                    const res = await fetch('{{ route('cart.ajax.add') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': window.csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id:   this.product.id,
                            product_type: this.product.type,
                            quantity:     this.quantity
                        })
                    });
                    const data = await res.json();
                    if (data.success) {
                        try {
                            const modalEl  = document.getElementById('modalProductDetail');
                            const modalIns = bootstrap.Modal.getInstance(modalEl);
                            if (modalIns) modalIns.hide();
                        } catch(e) {}

                        updateCartBadge(data.cartCount);

                        // Beritahu product-card stepper untuk update qty-nya
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: {
                            id:  this.product.id,
                            type: this.product.type,
                            qty: data.newQty ?? this.quantity
                        }}));

                        showCartToast(data.message || this.product.name + ' ditambahkan ke keranjang.', 'success');
                    } else {
                        showCartToast(data.message || 'Gagal menambahkan ke keranjang.', 'error');
                    }
                } catch (e) {
                    console.error(e);
                    showCartToast('Terjadi kesalahan, coba lagi.', 'error');
                } finally {
                    this.loading = false;
                }
            }
        }
    }
</script>
