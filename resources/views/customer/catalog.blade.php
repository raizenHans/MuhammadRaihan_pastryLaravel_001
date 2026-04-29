@extends('layouts.app')
@section('title', 'Katalog Menu — Artorious Pastry')

@push('styles')
<style>
.catalog-hero {
    text-align: center;
    padding: 48px 0 32px;
    position: relative;
}
.catalog-hero::before {
    content: '';
    position: absolute;
    left: 50%; top: 50%;
    transform: translate(-50%, -50%);
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(201,168,76,0.06), transparent 70%);
    pointer-events: none;
}
.catalog-eyebrow {
    font-family: 'Lato', sans-serif;
    font-size: 0.65rem;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    color: #C9A84C;
    margin-bottom: 10px;
}
.catalog-title {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem;
    font-weight: 700;
    color: #0D0D0D;
    margin-bottom: 8px;
}
.catalog-subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    color: #6B6560;
}

/* Tab pills */
.catalog-tabs {
    display: flex;
    justify-content: center;
    gap: 0;
    margin: 32px 0;
    background: #fff;
    border: 1px solid #E2D9CC;
    border-radius: 4px;
    overflow: hidden;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
}
.catalog-tab-btn {
    padding: 11px 28px;
    background: transparent;
    border: none;
    cursor: pointer;
    font-family: 'Lato', sans-serif;
    font-size: 0.82rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #6B6560;
    transition: all 0.3s;
    border-right: 1px solid #E2D9CC;
    display: flex;
    align-items: center;
    gap: 8px;
}
.catalog-tab-btn:last-child { border-right: none; }
.catalog-tab-btn.active {
    background: linear-gradient(135deg, #C9A84C, #8B6914);
    color: #fff;
}
.catalog-tab-btn:hover:not(.active) {
    background: #F5EDD8;
    color: #8B6914;
}
.tab-pane { display: none; }
.tab-pane.active { display: block; animation: tabFadeIn 0.35s ease; }
@keyframes tabFadeIn {
    from { opacity: 0; transform: translateY(8px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Empty state */
.empty-catalog {
    text-align: center;
    padding: 60px 20px;
    color: #6B6560;
}
.empty-catalog i { font-size: 3rem; color: #E2D9CC; margin-bottom: 16px; }
.empty-catalog p { font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; }
</style>
@endpush

@section('content')

<!-- Catalog Header -->
<div class="catalog-hero reveal">
    <div class="catalog-eyebrow">✦ &nbsp; Menu Pilihan &nbsp; ✦</div>
    <h1 class="catalog-title">Pilih Menu Favoritmu</h1>
    <p class="catalog-subtitle">Nikmati pastry segar dan minuman nikmat setiap hari.</p>
</div>

<!-- Tab Navigation -->
<div class="catalog-tabs" role="tablist">
    <button class="catalog-tab-btn active" id="tab-pastry" onclick="switchTab('pastry', this)">
        <i class="fa-solid fa-bread-slice"></i> Pastry
    </button>
    <button class="catalog-tab-btn" id="tab-drink" onclick="switchTab('drink', this)">
        <i class="fa-solid fa-mug-hot"></i> Minuman
    </button>
    <button class="catalog-tab-btn" id="tab-promo" onclick="switchTab('promo', this)">
        <i class="fa-solid fa-tags"></i> Promo Combo
    </button>
</div>

<!-- Tab Content -->
<div class="tab-content" id="menuTabsContent">

    <!-- Pastry Tab -->
    <div class="tab-pane active" id="tab-pastry-content">
        @if($pastries->count() > 0)
            <div class="row g-4">
                @foreach($pastries as $product)
                    @include('components.product-card', ['product' => $product, 'category' => 'Pastry'])
                @endforeach
            </div>
        @else
            <div class="empty-catalog">
                <i class="fa-solid fa-bread-slice"></i>
                <p>Belum ada produk pastry yang tersedia.</p>
            </div>
        @endif
    </div>

    <!-- Drink Tab -->
    <div class="tab-pane" id="tab-drink-content">
        @if($drinks->count() > 0)
            <div class="row g-4">
                @foreach($drinks as $product)
                    @include('components.product-card', ['product' => $product, 'category' => 'Minuman'])
                @endforeach
            </div>
        @else
            <div class="empty-catalog">
                <i class="fa-solid fa-mug-hot"></i>
                <p>Belum ada produk minuman yang tersedia.</p>
            </div>
        @endif
    </div>

    <!-- Promo Tab -->
    <div class="tab-pane" id="tab-promo-content">
        @if($promos->count() > 0)
            <div class="row g-4">
                @foreach($promos as $product)
                    @include('components.product-card', ['product' => $product, 'category' => 'Promo Combo'])
                @endforeach
            </div>
        @else
            <div class="empty-catalog">
                <i class="fa-solid fa-tags"></i>
                <p>Belum ada promo yang tersedia saat ini.</p>
            </div>
        @endif
    </div>
</div>

@include('components.modal-product-detail')

@endsection

@push('scripts')
<script>
function switchTab(tabName, clickedBtn) {
    // Hide all panes
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    // Deactivate all buttons
    document.querySelectorAll('.catalog-tab-btn').forEach(b => b.classList.remove('active'));
    // Show target pane & activate button
    document.getElementById('tab-' + tabName + '-content').classList.add('active');
    clickedBtn.classList.add('active');
}

// Re-attach IntersectionObserver for delayed loaded items
const ro = new IntersectionObserver(entries => {
    entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.08 });
document.querySelectorAll('.reveal').forEach(el => ro.observe(el));
</script>
@endpush