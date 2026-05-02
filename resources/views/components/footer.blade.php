<footer style="background: linear-gradient(135deg, #111108 0%, #0D0D0D 100%); color: rgba(255,255,255,0.7); padding: 60px 0 20px; border-top: 1px solid rgba(201,168,76,0.15); margin-top: auto;">
    <div class="container">
        <div class="row g-5 mb-5">
            <!-- Brand & Info -->
            <div class="col-lg-4 col-md-6">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Artorious Logo" style="height: 48px; width: 48px; border-radius: 50%; object-fit: cover; border: 2px solid #C9A84C;">
                    <div>
                        <div style="font-family:'Playfair Display',serif; color:#C9A84C; font-size:1.3rem; font-weight:700; line-height:1.1; letter-spacing:0.05em;">Artorious Pastry</div>
                        <div style="font-family:'Lato',sans-serif; color:rgba(255,255,255,0.45); font-size:0.65rem; letter-spacing:0.15em; text-transform:uppercase;">Artisan Bakery & Café</div>
                    </div>
                </div>
                <p style="font-family:'Cormorant Garamond',serif; font-size:1.05rem; line-height:1.8; color:rgba(255,255,255,0.6); margin-bottom:20px;">
                    Menyajikan pengalaman pastry autentik Eropa dan racikan kopi premium untuk menemani setiap momen spesial Anda.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="social-icon"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6">
                <h5 style="font-family:'Playfair Display',serif; color:#fff; font-size:1.2rem; margin-bottom:20px; position:relative; padding-bottom:10px;">
                    Jelajahi
                    <span style="position:absolute; bottom:0; left:0; width:40px; height:2px; background:#C9A84C;"></span>
                </h5>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="{{ route('home') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="font-size:0.7rem; color:#C9A84C; margin-right:6px;"></i> Beranda</a></li>
                    <li><a href="{{ route('catalog') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="font-size:0.7rem; color:#C9A84C; margin-right:6px;"></i> Katalog Menu</a></li>
                    <li><a href="{{ route('cart.index') }}" class="footer-link"><i class="fa-solid fa-angle-right" style="font-size:0.7rem; color:#C9A84C; margin-right:6px;"></i> Keranjang</a></li>
                    <li><a href="/login" class="footer-link"><i class="fa-solid fa-angle-right" style="font-size:0.7rem; color:#C9A84C; margin-right:6px;"></i> Staff Login</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h5 style="font-family:'Playfair Display',serif; color:#fff; font-size:1.2rem; margin-bottom:20px; position:relative; padding-bottom:10px;">
                    Kontak Kami
                    <span style="position:absolute; bottom:0; left:0; width:40px; height:2px; background:#C9A84C;"></span>
                </h5>
                <ul class="list-unstyled d-flex flex-column gap-3" style="font-family:'Lato',sans-serif; font-size:0.9rem; color:rgba(255,255,255,0.6);">
                    <li class="d-flex gap-3">
                        <i class="fa-solid fa-location-dot" style="color:#C9A84C; margin-top:4px;"></i>
                        <span>Jl. Asia Afrika No. 123, Bandung<br>Jawa Barat, Indonesia</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="fa-solid fa-phone" style="color:#C9A84C; margin-top:4px;"></i>
                        <span>+62 812 3456 7890</span>
                    </li>
                    <li class="d-flex gap-3">
                        <i class="fa-solid fa-envelope" style="color:#C9A84C; margin-top:4px;"></i>
                        <span>hello@artoriouspastry.com</span>
                    </li>
                </ul>
            </div>

            <!-- Jam Operasional -->
            <div class="col-lg-3 col-md-6">
                <h5 style="font-family:'Playfair Display',serif; color:#fff; font-size:1.2rem; margin-bottom:20px; position:relative; padding-bottom:10px;">
                    Jam Operasional
                    <span style="position:absolute; bottom:0; left:0; width:40px; height:2px; background:#C9A84C;"></span>
                </h5>
                <ul class="list-unstyled d-flex flex-column gap-2" style="font-family:'Lato',sans-serif; font-size:0.9rem; color:rgba(255,255,255,0.6);">
                    <li class="d-flex justify-content-between border-bottom pb-2" style="border-color:rgba(255,255,255,0.1) !important;">
                        <span>Senin - Jumat</span>
                        <span style="color:#C9A84C; font-weight:700;">07:00 - 21:00</span>
                    </li>
                    <li class="d-flex justify-content-between border-bottom pb-2 pt-1" style="border-color:rgba(255,255,255,0.1) !important;">
                        <span>Sabtu - Minggu</span>
                        <span style="color:#C9A84C; font-weight:700;">08:00 - 22:00</span>
                    </li>
                    <li class="d-flex justify-content-between pt-1">
                        <span>Hari Libur Nasional</span>
                        <span style="color:#FF8A9B; font-weight:700;">Tutup</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar (Copyright & Live Clock) -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 border-top" style="border-color:rgba(255,255,255,0.1) !important;">
            <div style="font-family:'Lato',sans-serif; font-size:0.8rem; color:rgba(255,255,255,0.4); margin-bottom:10px; margin-md-bottom:0;">
                &copy; {{ date('Y') }} Artorious Pastry. Hak Cipta Dilindungi.
            </div>
            
            <!-- Live Time Watch -->
            <div style="background:rgba(201,168,76,0.1); border:1px solid rgba(201,168,76,0.3); padding:6px 14px; border-radius:20px; display:flex; align-items:center; gap:8px;">
                <i class="fa-regular fa-clock" style="color:#C9A84C; font-size:0.9rem; animation: clockPulse 2s infinite;"></i>
                <span id="footer-live-clock" style="font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; color:#fff; letter-spacing:0.05em;">
                    --:--:--
                </span>
                <span style="font-family:'Lato',sans-serif; font-size:0.7rem; color:#C9A84C; margin-left:2px;">WIB</span>
            </div>
        </div>
    </div>
</footer>

<style>
    .social-icon {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        color: #C9A84C;
        display: flex; align-items: center; justify-content: center;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.16,1,0.3,1);
        border: 1px solid rgba(201,168,76,0.2);
    }
    .social-icon:hover {
        background: #C9A84C;
        color: #fff;
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(201,168,76,0.3);
    }
    .footer-link {
        font-family: 'Lato', sans-serif;
        font-size: 0.9rem;
        color: rgba(255,255,255,0.6);
        text-decoration: none;
        transition: all 0.2s;
    }
    .footer-link:hover {
        color: #C9A84C;
        padding-left: 6px;
    }
    @keyframes clockPulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>

<script>
    function updateLiveClock() {
        const clockElement = document.getElementById('footer-live-clock');
        if (!clockElement) return;
        
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        clockElement.textContent = `${hours}:${minutes}:${seconds}`;
    }
    
    // Update segera dan set interval
    updateLiveClock();
    setInterval(updateLiveClock, 1000);
</script>
