<div class="col-md-4 col-sm-6 mb-4 reveal">
    <div class="product-card-wrap">
        <!-- Product Image -->
        <div class="product-img-wrap">
            @if($product->image_path)
                <img src="{{ asset('storage/' . $product->image_path) }}"
                     alt="{{ $product->name }}"
                     class="product-img"
                     loading="lazy">
            @else
                <div class="product-img-placeholder">
                    <i class="fa-solid fa-croissant"></i>
                </div>
            @endif
            <!-- Category Badge -->
            <span class="product-category-badge">{{ $category ?? 'Menu' }}</span>
        </div>

        <!-- Card Body -->
        <div class="product-card-body">
            <h5 class="product-name">{{ $product->name }}</h5>
            <div class="product-footer">
                <div class="product-price">
                    <span class="price-label">Rp</span>
                    <span class="price-value">{{ number_format($product->price, 0, ',', '.') }}</span>
                </div>

                <!-- Alpine Inline Stepper -->
                @php
                    $itemKey = class_basename($product) . '_' . $product->id;
                    $initialQty = (isset($cartItems) && $cartItems->has($itemKey)) ? $cartItems->get($itemKey)->quantity : 0;
                @endphp
                <div x-data="{
                    qty: {{ $initialQty }},
                    loading: false,
                    async updateCart(newQty) {
                        if (this.loading || newQty < 0) return;
                        this.loading = true;
                        try {
                            const res = await fetch('{{ route('cart.ajax.update') }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': window.csrfToken,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    product_type: '{{ class_basename($product) }}',
                                    quantity: newQty
                                })
                            });
                            const data = await res.json();
                            if (data.success) {
                                this.qty = data.newQty;
                                updateCartBadge(data.cartCount);
                            }
                        } catch (e) {
                            console.error(e);
                        } finally {
                            this.loading = false;
                        }
                    }
                }" 
                @cart-updated.window="if ($event.detail.id == {{ $product->id }} && $event.detail.type == '{{ class_basename($product) }}') { qty = $event.detail.qty; }"
                class="stepper-wrap">
                    
                    <!-- View: Add Button (qty == 0) -->
                    <button x-show="qty === 0" 
                            data-bs-toggle="modal" data-bs-target="#modalProductDetail"
                            @click='$dispatch("open-product-modal", {!! json_encode([
                                "id" => $product->id,
                                "name" => $product->name,
                                "price" => (float)$product->price,
                                "type" => class_basename($product),
                                "image_path" => $product->image_path,
                                "description" => $product->description ?? "",
                                "category" => $category ?? "Menu"
                            ], JSON_HEX_APOS) !!})'
                            class="btn-order" :disabled="loading">
                        <i class="fa-solid fa-plus" x-show="!loading"></i>
                        <i class="fa-solid fa-spinner fa-spin" x-show="loading"></i>
                        <span>Pesan</span>
                    </button>

                    <!-- View: Stepper (qty > 0) -->
                    <div x-show="qty > 0" class="numeric-stepper" style="display:none;" x-transition>
                        <button @click="updateCart(qty - 1)" class="stepper-btn" :disabled="loading">
                            <i class="fa-solid" :class="qty === 1 ? 'fa-trash-can' : 'fa-minus'"></i>
                        </button>
                        <span class="stepper-val" x-text="qty"></span>
                        <button @click="updateCart(qty + 1)" class="stepper-btn" :disabled="loading">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Stock Warning -->
        @if(isset($product->stock) && $product->stock < 10)
        <div class="stock-warning">
            <i class="fa-solid fa-triangle-exclamation"></i> Stok tersisa {{ $product->stock }}
        </div>
        @endif
    </div>
</div>

<style>
.product-card-wrap {
    background: #fff;
    border: 1px solid #E2D9CC;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(13,13,13,0.06);
    transition: transform 0.35s ease, box-shadow 0.35s ease;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.product-card-wrap:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 36px rgba(13,13,13,0.14);
}
.product-card-wrap:hover .btn-order {
    background: linear-gradient(135deg, #8B6914, #5A4008);
}
.product-img-wrap {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #F5EDD8;
}
.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.product-card-wrap:hover .product-img {
    transform: scale(1.05);
}
.product-img-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #F5EDD8, #E8D5A3);
}
.product-img-placeholder i {
    font-size: 3.5rem;
    color: #C9A84C;
    opacity: 0.6;
}
.product-category-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: rgba(13,13,13,0.8);
    color: #C9A84C;
    font-family: 'Lato', sans-serif;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 3px 9px;
    border-radius: 2px;
    backdrop-filter: blur(4px);
}
.product-card-body {
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
    flex: 1;
}
.product-name {
    font-family: 'Playfair Display', serif;
    font-size: 1rem;
    font-weight: 600;
    color: #0D0D0D;
    margin: 0;
    line-height: 1.3;
}
.product-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
}
.product-price {
    display: flex;
    align-items: baseline;
    gap: 3px;
}
.price-label {
    font-size: 0.75rem;
    color: #8B6914;
    font-weight: 700;
    font-family: 'Lato', sans-serif;
}
.price-value {
    font-family: 'Playfair Display', serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: #8B6914;
}
.btn-order {
    background: linear-gradient(135deg, #C9A84C, #8B6914);
    color: #fff;
    border: none;
    padding: 7px 14px;
    border-radius: 3px;
    font-family: 'Lato', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s;
}
.btn-order:hover {
    box-shadow: 0 4px 14px rgba(201,168,76,0.4);
    transform: translateY(-1px);
}
.stock-warning {
    background: #FFF3CD;
    border-top: 1px solid #F0D060;
    color: #856404;
    font-size: 0.72rem;
    font-family: 'Lato', sans-serif;
    padding: 5px 12px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Numeric Stepper Styles */
.stepper-wrap { min-width: 90px; display: flex; justify-content: flex-end; }
.numeric-stepper {
    display: flex;
    align-items: center;
    background: #F5EDD8;
    border: 1px solid #E8D5A3;
    border-radius: 4px;
    overflow: hidden;
    height: 32px;
}
.stepper-btn {
    background: transparent;
    border: none;
    color: #8B6914;
    width: 32px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.stepper-btn:hover:not(:disabled) { background: #E8D5A3; color: #5A4008; }
.stepper-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.stepper-val {
    font-family: 'Lato', sans-serif;
    font-weight: 700;
    color: #0D0D0D;
    padding: 0 8px;
    min-width: 28px;
    text-align: center;
}
</style>