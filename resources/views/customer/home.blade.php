@extends('layouts.app')
@section('title', 'Beranda — Artorious Pastry')

@push('styles')
<style>
/* ===== HERO ===== */
.hero-section {
    position: relative;
    min-height: 85vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0D0D0D;
    /* Teknik untuk break container Bootstrap dan menempel navbar */
    margin: 0 calc(-50vw + 50%) 0;
}
.hero-bg {
    position: absolute; inset: 0;
    background:
        linear-gradient(135deg, rgba(13,13,13,0.92) 0%, rgba(13,13,13,0.7) 60%, rgba(13,13,13,0.85) 100%),
        url('https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=1600&q=80') center/cover no-repeat;
}
.hero-pattern {
    position: absolute; inset: 0;
    background-image: radial-gradient(circle, rgba(201,168,76,0.05) 1px, transparent 1px);
    background-size: 50px 50px;
    pointer-events: none;
}
.hero-content {
    position: relative; z-index: 2;
    padding: 80px 40px;
    max-width: 700px;
}
.hero-eyebrow {
    font-family: 'Lato', sans-serif;
    font-size: 0.7rem;
    letter-spacing: 0.3em;
    text-transform: uppercase;
    color: #C9A84C;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.hero-eyebrow::before, .hero-eyebrow::after {
    content: '';
    width: 30px; height: 1px;
    background: #C9A84C;
}
.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.4rem, 5vw, 3.8rem);
    font-weight: 700;
    color: #fff;
    line-height: 1.15;
    margin-bottom: 20px;
}
.hero-title em {
    color: #C9A84C;
    font-style: italic;
    animation: textGlowBreath 3s ease-in-out infinite;
}
@keyframes textGlowBreath {
    0%, 100% { text-shadow: 0 0 5px rgba(201,168,76,0.2), 0 0 10px rgba(201,168,76,0.1); }
    50%      { text-shadow: 0 0 15px rgba(201,168,76,0.8), 0 0 30px rgba(201,168,76,0.5), 0 0 45px rgba(201,168,76,0.3); }
}
.hero-subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem;
    color: rgba(255,255,255,0.65);
    margin-bottom: 36px;
    line-height: 1.8;
}
.hero-cta-wrap { display: flex; gap: 16px; flex-wrap: wrap; }
.hero-cta {
    background: linear-gradient(135deg, #C9A84C, #8B6914);
    color: #fff;
    text-decoration: none;
    padding: 14px 32px;
    border-radius: 3px;
    font-family: 'Lato', sans-serif;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    transition: all 0.35s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}
.hero-cta:hover {
    background: linear-gradient(135deg, #8B6914, #5A4008);
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(201,168,76,0.4);
}
.hero-cta-outline {
    border: 2px solid rgba(255,255,255,0.25);
    color: rgba(255,255,255,0.8);
    text-decoration: none;
    padding: 13px 28px;
    border-radius: 3px;
    font-family: 'Lato', sans-serif;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.hero-cta-outline:hover {
    border-color: #C9A84C;
    color: #C9A84C;
}

/* ===== MARQUEE BAR ===== */
.marquee-bar {
    background: linear-gradient(90deg, #C9A84C, #8B6914);
    padding: 10px 0;
    overflow: hidden;
    white-space: nowrap;
    margin: 0 calc(-50vw + 50%); /* Membuatnya full-width edge-to-edge */
}
.marquee-inner {
    display: inline-flex;
    animation: marqueeScroll 25s linear infinite;
    gap: 0;
}
.marquee-item {
    font-family: 'Lato', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: #fff;
    padding: 0 32px;
}
.marquee-sep { color: rgba(255,255,255,0.5); }
@keyframes marqueeScroll {
    from { transform: translateX(0); }
    to { transform: translateX(-50%); }
}

/* ===== FEATURES ===== */
.features-section { padding: 80px 0; }
.section-eyebrow {
    font-family: 'Lato', sans-serif;
    font-size: 0.68rem;
    letter-spacing: 0.25em;
    text-transform: uppercase;
    color: #C9A84C;
    text-align: center;
    margin-bottom: 10px;
}
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 2rem;
    text-align: center;
    color: #0D0D0D;
    margin-bottom: 8px;
    font-weight: 600;
}
.section-subtitle {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.1rem;
    text-align: center;
    color: #6B6560;
    margin-bottom: 48px;
}
.feature-card {
    background: #fff;
    border: 1px solid #E2D9CC;
    border-radius: 4px;
    padding: 32px 24px;
    text-align: center;
    transition: transform 0.4s cubic-bezier(0.16,1,0.3,1), box-shadow 0.4s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}
.feature-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #C9A84C, #8B6914);
    transform: scaleX(0);
    transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.feature-card:hover { transform: translateY(-8px); box-shadow: 0 20px 48px rgba(13,13,13,0.12); }
.feature-card:hover::after { transform: scaleX(1); }
.feature-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #F5EDD8, #E8D5A3);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 22px;
    font-size: 1.6rem;
    color: #8B6914;
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    box-shadow: 0 4px 16px rgba(201,168,76,0.15);
}
.feature-card:hover .feature-icon {
    background: linear-gradient(135deg, #C9A84C, #8B6914);
    color: #fff;
    box-shadow: 0 8px 28px rgba(201,168,76,0.4);
    transform: scale(1.08);
}
.feature-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem;
    font-weight: 600;
    color: #0D0D0D;
    margin-bottom: 10px;
}
.feature-text {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1rem;
    color: #6B6560;
    line-height: 1.7;
}

/* ===== ABOUT SECTION ===== */
.about-section { padding: 80px 0; background: #FAF7F2; margin: 0 -15px; padding-left: 15px; padding-right: 15px; }
.about-img-wrap {
    position: relative;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(13,13,13,0.18);
}
.about-img-wrap img { width: 100%; height: 420px; object-fit: cover; display: block; }
.about-img-badge {
    position: absolute; bottom: 24px; left: 24px;
    background: linear-gradient(135deg,#C9A84C,#8B6914);
    color: #fff; border-radius: 3px; padding: 12px 20px;
    font-family: 'Lato', sans-serif; font-size: 0.75rem; font-weight: 700;
    letter-spacing: 0.08em; text-transform: uppercase;
    box-shadow: 0 4px 20px rgba(201,168,76,0.5);
}
.about-badge-num {
    font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; display: block; line-height: 1;
}
.stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 32px; }
.stat-item { text-align: center; }
.stat-num {
    font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700;
    color: #C9A84C; display: block; line-height: 1;
}
.stat-label { font-family: 'Lato', sans-serif; font-size: 0.72rem; color: #6B6560; text-transform: uppercase; letter-spacing: 0.1em; margin-top: 4px; display: block; }

/* ===== PROCESS SECTION ===== */
.process-section { padding: 80px 0; }
.process-step {
    text-align: center; padding: 0 16px;
    position: relative;
    transition: transform 0.4s cubic-bezier(0.16,1,0.3,1);
}
.process-step:hover { transform: translateY(-6px); }
.process-num {
    width: 60px; height: 60px;
    background: linear-gradient(135deg,#111108,#1C1C17);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; color: #C9A84C;
    box-shadow: 0 4px 20px rgba(13,13,13,0.2);
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
}
.process-step:hover .process-num {
    background: linear-gradient(135deg,#C9A84C,#8B6914);
    color: #fff;
    box-shadow: 0 8px 28px rgba(201,168,76,0.5);
}
.process-connector {
    position: absolute; top: 30px; right: -50%;
    width: 100%; height: 1px;
    background: linear-gradient(90deg,#C9A84C,transparent);
    pointer-events: none;
}

/* ===== TESTIMONIAL ===== */
.testimonial-section {
    background: linear-gradient(135deg,#111108,#1C1C17);
    position: relative;
    overflow: hidden;
    /* padding & margin dikendalikan via inline style untuk full-width */
}
.testimonial-section::before {
    content: '"'; position: absolute; top: -20px; left: 20px;
    font-family: 'Playfair Display', serif; font-size: 18rem;
    color: rgba(201,168,76,0.04); line-height: 1; pointer-events: none;
}
.testi-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(201,168,76,0.15);
    border-radius: 4px; padding: 28px 24px;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.16,1,0.3,1);
    position: relative;
}
.testi-card:hover {
    background: rgba(201,168,76,0.06);
    border-color: rgba(201,168,76,0.35);
    transform: translateY(-6px);
}
.testi-stars { color: #C9A84C; font-size: 0.85rem; margin-bottom: 14px; }
.testi-text {
    font-family: 'Cormorant Garamond', serif; font-size: 1.05rem;
    color: rgba(255,255,255,0.75); line-height: 1.8; margin-bottom: 20px;
    font-style: italic;
}
.testi-author { display: flex; align-items: center; gap: 12px; }
.testi-avatar {
    width: 44px; height: 44px; border-radius: 50%;
    background: linear-gradient(135deg,#C9A84C,#8B6914);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Playfair Display', serif; font-size: 1rem; font-weight: 700; color: #fff;
    flex-shrink: 0;
}
.testi-name { font-family: 'Lato', sans-serif; font-size: 0.85rem; font-weight: 700; color: #fff; }
.testi-role { font-family: 'Lato', sans-serif; font-size: 0.72rem; color: rgba(201,168,76,0.6); }

/* ===== MEMBER SECTION ===== */
.member-section {
    background: linear-gradient(135deg, #111108 0%, #1C1C17 100%);
    border-radius: 6px;
    padding: 56px 48px;
    margin: 0 0 60px;
    position: relative;
    overflow: hidden;
}
.member-section::before {
    content: '';
    position: absolute; inset: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C9A84C' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    pointer-events: none;
}
.member-ornament {
    position: absolute;
    top: -40px; right: -40px;
    width: 200px; height: 200px;
    border: 2px solid rgba(201,168,76,0.12);
    border-radius: 50%;
    pointer-events: none;
}
.member-ornament::after {
    content: '';
    position: absolute;
    inset: 20px;
    border: 1px solid rgba(201,168,76,0.08);
    border-radius: 50%;
}
.member-gold-line {
    height: 1px;
    background: linear-gradient(90deg, transparent, #C9A84C, transparent);
    margin: 16px 0 24px;
}

/* ===== AUTH MODALS ===== */
.modal-european .modal-content {
    border: none;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.4);
}
.modal-european .modal-header {
    background: linear-gradient(135deg, #0D0D0D, #1C1C17);
    padding: 20px 24px;
    border: none;
    position: relative;
}
.modal-european .modal-header::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, #C9A84C, #8B6914, #C9A84C);
}
.modal-european .modal-title {
    font-family: 'Playfair Display', serif;
    color: #fff;
    font-size: 1.2rem;
    font-weight: 600;
}
.modal-european .modal-body { padding: 28px 24px; background: #fff; }
.modal-input {
    border: 1px solid #E2D9CC;
    border-radius: 3px;
    font-family: 'Lato', sans-serif;
    padding: 11px 14px;
    width: 100%;
    transition: border-color 0.3s, box-shadow 0.3s;
    font-size: 0.9rem;
}
.modal-input:focus {
    border-color: #C9A84C;
    box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
    outline: none;
}
.modal-label {
    font-family: 'Lato', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #6B6560;
    margin-bottom: 6px;
    display: block;
}
.modal-submit {
    width: 100%;
    background: linear-gradient(135deg, #C9A84C, #8B6914);
    color: #fff; border: none;
    padding: 12px;
    border-radius: 3px;
    font-family: 'Lato', sans-serif;
    font-size: 0.85rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s;
}
.modal-submit:hover {
    background: linear-gradient(135deg, #8B6914, #5A4008);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(201,168,76,0.4);
}
</style>
@endpush

@section('content')

<!-- ===== HERO SECTION ===== -->
<div class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-pattern"></div>
    <div class="container">
        <div class="hero-content">
            <div class="hero-eyebrow">Artisan Bakery & Café</div>
            <h1 class="hero-title">
                Cita Rasa <em>Eropa</em><br>Hadir di Meja Anda
            </h1>
            <p class="hero-subtitle">
                Pastry autentik dipanggang setiap pagi dengan mentega premium — dipadukan racikan kopi pilihan untuk menemani momen sempurna Anda.
            </p>
            <div class="hero-cta-wrap">
                <a href="{{ route('catalog') }}" class="hero-cta">
                    <i class="fa-solid fa-utensils"></i> Pesan Sekarang
                </a>
                @guest
                <button class="hero-cta-outline" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="fa-solid fa-crown"></i> Jadi Member
                </button>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- ===== MARQUEE ===== -->
<div class="marquee-bar">
    <div class="marquee-inner">
        @for($i = 0; $i < 2; $i++)
        <span class="marquee-item">Fresh Pastry</span><span class="marquee-sep">✦</span>
        <span class="marquee-item">Signature Coffee</span><span class="marquee-sep">✦</span>
        <span class="marquee-item">Promo Combo</span><span class="marquee-sep">✦</span>
        <span class="marquee-item">Member Points</span><span class="marquee-sep">✦</span>
        <span class="marquee-item">Croissant Artisan</span><span class="marquee-sep">✦</span>
        <span class="marquee-item">Matcha Latte</span><span class="marquee-sep">✦</span>
        @endfor
    </div>
</div>

<!-- ===== FEATURES ===== -->
<div class="features-section">
    <div class="section-eyebrow">Keunggulan Kami</div>
    <h2 class="section-title">Pengalaman Untuk Dijaga</h2>
    <p class="section-subtitle">Setiap detail dirancang untuk memberikan pengalaman terbaik.</p>

    <div class="row g-4">
        <div class="col-md-4 reveal">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-bread-slice"></i></div>
                <div class="feature-title">Fresh Pastry</div>
                <p class="feature-text">Dipanggang segar setiap pagi menggunakan mentega premium dan tepung pilihan bergaya Eropa.</p>
            </div>
        </div>
        <div class="col-md-4 reveal" style="transition-delay:0.15s">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-mug-hot"></i></div>
                <div class="feature-title">Signature Drinks</div>
                <p class="feature-text">Dari Espresso murni hingga Matcha autentik — setiap tegukan adalah perjalanan rasa.</p>
            </div>
        </div>
        <div class="col-md-4 reveal" style="transition-delay:0.3s">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-star"></i></div>
                <div class="feature-title">Member Rewards</div>
                <p class="feature-text">Kumpulkan poin setiap transaksi dan nikmati diskon eksklusif untuk member setia.</p>
            </div>
        </div>
    </div>
</div>

<!-- ===== ABOUT SECTION ===== -->
<div class="about-section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5 reveal">
                <div class="about-img-wrap">
                    <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&q=85" alt="Artorious Pastry Dapur">
                    <div class="about-img-badge">
                        <span class="about-badge-num">2024</span>
                        <span style="font-size:0.7rem; opacity:0.85;">Est. Artorious Pastry</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 reveal" style="transition-delay:0.2s">
                <div style="font-family:'Lato',sans-serif; font-size:0.68rem; letter-spacing:0.25em; text-transform:uppercase; color:#C9A84C; margin-bottom:10px;">Tentang Kami</div>
                <h2 style="font-family:'Playfair Display',serif; font-size:2rem; color:#0D0D0D; font-weight:600; margin-bottom:16px; line-height:1.3;">
                    Artorious Pastry — <em style="color:#C9A84C; font-style:italic;">Cita Rasa Eropa</em> di Jantung Kota
                </h2>
                <div style="height:2px; width:60px; background:linear-gradient(90deg,#C9A84C,#8B6914); margin-bottom:20px;"></div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:1.1rem; color:#6B6560; line-height:1.9; margin-bottom:16px;">
                    Artorious Pastry lahir dari kecintaan mendalam terhadap seni membuat roti bergaya Eropa. Setiap produk kami menggunakan bahan-bahan pilihan — mentega premium grade-A, tepung protein tinggi pilihan, dan perisa alami tanpa pengawet.
                </p>
                <p style="font-family:'Cormorant Garamond',serif; font-size:1.1rem; color:#6B6560; line-height:1.9; margin-bottom:28px;">
                    Dipanggang setiap pagi sebelum toko dibuka, memastikan setiap gigitan menghadirkan kelembutan dan kesegaran yang autentik. Kami percaya bahwa kualitas bukan pilihan — ia adalah standar.
                </p>
                <div class="stat-grid">
                    <div class="stat-item">
                        <span class="stat-num">50+</span>
                        <span class="stat-label">Varian Produk</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">1000+</span>
                        <span class="stat-label">Member Setia</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-num">100%</span>
                        <span class="stat-label">Bahan Premium</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== PROCESS SECTION ===== -->
<div class="process-section">
    <div class="section-eyebrow">Bagaimana Cara Kerja Kami</div>
    <h2 class="section-title">Dari Dapur ke Meja Anda</h2>
    <p class="section-subtitle">Proses sederhana, kualitas luar biasa.</p>
    <div class="row g-4 mt-2">
        <div class="col-md-3 col-6 reveal">
            <div class="process-step">
                <div class="process-num">01</div>
                <div style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#0D0D0D; margin-bottom:8px;">Pilih Menu</div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:0.97rem; color:#6B6560; line-height:1.7;">Jelajahi katalog pastry & minuman kami yang beragam.</p>
            </div>
        </div>
        <div class="col-md-3 col-6 reveal" style="transition-delay:0.1s">
            <div class="process-step">
                <div class="process-num">02</div>
                <div style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#0D0D0D; margin-bottom:8px;">Tambah Keranjang</div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:0.97rem; color:#6B6560; line-height:1.7;">Masukkan pilihan ke keranjang dan atur jumlahnya.</p>
            </div>
        </div>
        <div class="col-md-3 col-6 reveal" style="transition-delay:0.2s">
            <div class="process-step">
                <div class="process-num">03</div>
                <div style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#0D0D0D; margin-bottom:8px;">Checkout</div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:0.97rem; color:#6B6560; line-height:1.7;">Konfirmasi pesanan dan dapatkan kode transaksi unik.</p>
            </div>
        </div>
        <div class="col-md-3 col-6 reveal" style="transition-delay:0.3s">
            <div class="process-step">
                <div class="process-num">04</div>
                <div style="font-family:'Playfair Display',serif; font-size:1rem; font-weight:600; color:#0D0D0D; margin-bottom:8px;">Nikmati!</div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:0.97rem; color:#6B6560; line-height:1.7;">Bayar di kasir, ambil pesanan segar, dan nikmati!</p>
            </div>
        </div>
    </div>
</div>

<!-- ===== TESTIMONIAL SECTION ===== -->
{{-- Full-width: keluar dari container Bootstrap dengan margin negatif --}}
<div class="testimonial-section" style="
    margin-left: calc(-50vw + 50%);
    margin-right: calc(-50vw + 50%);
    padding: 80px calc(50vw - 50% + 20px);
    margin-bottom: 60px;
">
    <div style="max-width:1160px; margin:0 auto; padding:0 20px;">
        <div style="font-family:'Lato',sans-serif; font-size:0.68rem; letter-spacing:0.25em; text-transform:uppercase; color:rgba(201,168,76,0.6); text-align:center; margin-bottom:10px;">Kata Pelanggan</div>
        <h2 style="font-family:'Playfair Display',serif; font-size:2rem; text-align:center; color:#fff; font-weight:600; margin-bottom:8px;">Yang Mereka Katakan</h2>
        <p style="font-family:'Cormorant Garamond',serif; font-size:1.1rem; text-align:center; color:rgba(255,255,255,0.5); margin-bottom:48px;">Kepercayaan pelanggan adalah mahkota kami.</p>
        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"Croissant-nya luar biasa! Berlapis sempurna, menteganya terasa di setiap gigitan. Ini tempat favorit saya untuk sarapan setiap hari."
                    </p>
                    <div class="testi-author">
                        <div class="testi-avatar">A</div>
                        <div>
                            <div class="testi-name">Aisyah R.</div>
                            <div class="testi-role">Member Premium</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal" style="transition-delay:0.15s">
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"Sistem member poin-nya sangat menguntungkan! Sudah berkali-kali dapat diskon. Kopi Matcha Latte-nya juga tidak ada tandingannya."
                    </p>
                    <div class="testi-author">
                        <div class="testi-avatar">B</div>
                        <div>
                            <div class="testi-name">Budi S.</div>
                            <div class="testi-role">Member Setia</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 reveal" style="transition-delay:0.3s">
                <div class="testi-card">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"Pelayanan cepat dan ramah. Pre-order via aplikasi sangat memudahkan, tinggal ambil dan bayar. Sangat rekomendasikan!"
                    </p>
                    <div class="testi-author">
                        <div class="testi-avatar">D</div>
                        <div>
                            <div class="testi-name">Diana P.</div>
                            <div class="testi-role">Pelanggan Baru</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== MEMBER / AUTH SECTION ===== -->
@guest
<div class="member-section reveal">
    <div class="member-ornament"></div>
    <div style="position:relative; z-index:1; max-width:600px; margin:0 auto; text-align:center;">
        <div style="font-family:'Lato',sans-serif; font-size:0.65rem; letter-spacing:0.3em; text-transform:uppercase; color:rgba(201,168,76,0.6); margin-bottom:12px;">Bergabunglah Dengan Kami</div>
        <h2 style="font-family:'Playfair Display',serif; color:#fff; font-size:2rem; font-weight:600; margin-bottom:8px;">
            Jadi Member <span style="color:#C9A84C; font-style:italic;">Eksklusif</span>
        </h2>
        <div class="member-gold-line"></div>
        <p style="font-family:'Cormorant Garamond',serif; color:rgba(255,255,255,0.6); font-size:1.05rem; line-height:1.8; margin-bottom:32px;">
            Kumpulkan poin setiap transaksi dan dapatkan diskon otomatis.<br>Hemat lebih banyak dengan setiap kunjungan.
        </p>
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <button class="hero-cta-outline" data-bs-toggle="modal" data-bs-target="#loginModal"
                    style="border-color:rgba(201,168,76,0.4); color:#0D0D0D; background:rgba(255,255,255,0.92); border-radius:3px; padding:13px 28px; font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.08em; text-transform:uppercase; cursor:pointer; display:inline-flex; align-items:center; gap:8px; transition:all 0.3s; border:1.5px solid rgba(201,168,76,0.5);">
                <i class="fa-solid fa-right-to-bracket" style="color:#8B6914;"></i> Masuk
            </button>
            <button style="
                background:linear-gradient(135deg,#C9A84C,#8B6914);
                color:#fff; border:none;
                padding:13px 28px; border-radius:3px;
                font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700;
                letter-spacing:0.08em; text-transform:uppercase; cursor:pointer;
                display:inline-flex; align-items:center; gap:8px;
                transition:all 0.3s;
            "
            data-bs-toggle="modal" data-bs-target="#registerModal"
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 24px rgba(201,168,76,0.4)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <i class="fa-solid fa-crown"></i> Daftar Member
            </button>
        </div>
    </div>
</div>

<!-- LOGIN MODAL -->
<div class="modal fade modal-european" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <div style="font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); font-family:'Lato',sans-serif; margin-bottom:4px;">Selamat Datang Kembali</div>
                    <h5 class="modal-title">Masuk ke Akun Anda</h5>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @if($errors->any())
                <div style="background:#FBF0F2; border:1px solid #6B2D3E; border-left:4px solid #6B2D3E; border-radius:3px; padding:10px 14px; margin-bottom:16px; font-size:0.84rem; color:#0D0D0D; font-family:'Lato',sans-serif;">
                    {{ $errors->first() }}
                </div>
                @endif
                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="modal-label">Alamat Email</label>
                        <input type="email" name="email" class="modal-input" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-5">
                        <label class="modal-label">Password</label>
                        <input type="password" name="password" class="modal-input" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="modal-submit"><i class="fa-solid fa-right-to-bracket"></i> &nbsp; Masuk Sekarang</button>
                </form>
                <p style="text-align:center; font-family:'Lato',sans-serif; font-size:0.78rem; color:#6B6560; margin-top:16px;">
                    Belum punya akun? <a href="#" style="color:#8B6914; font-weight:700; text-decoration:none;" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Daftar Member</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- REGISTER MODAL -->
<div class="modal fade modal-european" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <div style="font-size:0.62rem; letter-spacing:0.2em; text-transform:uppercase; color:rgba(201,168,76,0.6); font-family:'Lato',sans-serif; margin-bottom:4px;">Bergabunglah Sekarang</div>
                    <h5 class="modal-title"><i class="fa-solid fa-crown" style="color:#C9A84C;"></i> Pendaftaran Member</h5>
                </div>
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('register.process') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="modal-label">Nama Lengkap <span style="color:#6B2D3E;">*</span></label>
                        <input type="text" name="name" class="modal-input" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="modal-label">Email <span style="color:#6B2D3E;">*</span></label>
                            <input type="email" name="email" class="modal-input" required>
                        </div>
                        <div class="col-6">
                            <label class="modal-label">No. WhatsApp</label>
                            <input type="text" name="phone" class="modal-input">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="modal-label">NIK (16 digit) <span style="color:#6B2D3E;">*</span></label>
                        <input type="text" name="nik" class="modal-input" minlength="16" maxlength="16" required>
                        <div style="font-size:0.72rem; color:#6B6560; font-family:'Lato',sans-serif; margin-top:4px;">Untuk verifikasi keamanan.</div>
                    </div>
                    <div class="mb-4">
                        <label class="modal-label">Password <span style="color:#6B2D3E;">*</span></label>
                        <input type="password" name="password" class="modal-input" required>
                    </div>
                    <button type="submit" class="modal-submit"><i class="fa-solid fa-crown"></i> &nbsp; Daftar Sebagai Member</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endguest

@auth
<div style="background:linear-gradient(135deg,#111108,#1C1C17); border-radius:6px; padding:28px 32px; margin-bottom:40px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; align-items:center; gap:16px;">
        <div style="width:52px; height:52px; background:linear-gradient(135deg,#C9A84C,#8B6914); border-radius:50%; display:flex; align-items:center; justify-content:center;">
            <i class="fa-solid fa-user" style="color:#fff; font-size:1.2rem;"></i>
        </div>
        <div>
            <h3 style="font-family:'Playfair Display',serif; color:#fff; font-size:1.2rem; margin:0 0 4px;">Halo, {{ Auth::user()->name }}!</h3>
            @if(Auth::user()->role == 'customer' && Auth::user()->memberProfile)
                <p style="margin:0; font-family:'Lato',sans-serif; font-size:0.82rem; color:rgba(255,255,255,0.55);">
                    Kode Member: <strong style="color:#C9A84C;">{{ Auth::user()->memberProfile->member_code }}</strong>
                    &nbsp;|&nbsp;
                    Poin: <strong style="color:#C9A84C;">{{ Auth::user()->memberProfile->points }}</strong>
                </p>
            @else
                <p style="margin:0; font-family:'Lato',sans-serif; font-size:0.78rem; color:rgba(255,255,255,0.45); letter-spacing:0.08em; text-transform:uppercase;">{{ Auth::user()->role }}</p>
            @endif
        </div>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <a href="{{ route('catalog') }}" style="background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; text-decoration:none; padding:10px 20px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.8rem; font-weight:700; letter-spacing:0.06em; display:inline-flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-utensils"></i> Pesan Sekarang
        </a>
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" style="border:1.5px solid rgba(107,45,62,0.5); color:rgba(255,255,255,0.5); background:transparent; padding:10px 16px; border-radius:3px; font-family:'Lato',sans-serif; font-size:0.8rem; cursor:pointer; display:flex; align-items:center; gap:6px; transition:all 0.3s;" onmouseover="this.style.background='rgba(107,45,62,0.3)'; this.style.color='#fff';" onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.5)';">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>
</div>
@endauth

@endsection