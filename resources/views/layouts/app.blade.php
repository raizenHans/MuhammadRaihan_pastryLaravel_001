<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Artorious Pastry — Artisan Pastry & Coffee')</title>
    <meta name="description" content="Nikmati pastry artisan autentik bergaya Eropa dan racikan kopi premium di Artorious Pastry.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Classical European -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* =============================================
           ARTORIOUS PASTRY — CLASSICAL EUROPEAN DESIGN SYSTEM
           ============================================= */
        :root {
            --gold:         #C9A84C;
            --gold-dark:    #8B6914;
            --gold-light:   #E8D5A3;
            --gold-pale:    #F5EDD8;
            --cream:        #FAF7F2;
            --cream-dark:   #F0EAE0;
            --cream-border: #E2D9CC;
            --noir:         #0D0D0D;
            --noir-soft:    #1A1A1A;
            --noir-card:    #222018;
            --warm-gray:    #6B6560;
            --warm-light:   #9E9690;
            --burgundy:     #6B2D3E;
            --burgundy-light:#8B3D52;
            --success-dark: #1D4D30;
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body:    'Cormorant Garamond', Georgia, serif;
            --font-ui:      'Lato', sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--cream);
            font-family: var(--font-ui);
            color: var(--noir);
            line-height: 1.7;
            /* ===== STICKY FOOTER FIX ===== */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ---- Typography ---- */
        h1, h2, h3, .heading { font-family: var(--font-heading); }
        h4, h5, .subheading  { font-family: var(--font-heading); font-weight: 600; }
        p, .body-text         { font-family: var(--font-body); font-size: 1.05rem; }

        /* ---- Gold Ornamental Divider ---- */
        .ornament-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 1.5rem 0;
        }
        .ornament-divider::before,
        .ornament-divider::after {
            content: ''; flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--gold), transparent);
        }
        .ornament-divider span {
            color: var(--gold);
            font-size: 1.2rem;
        }

        /* ---- Gold Buttons ---- */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            color: #fff;
            font-family: var(--font-ui);
            font-weight: 700;
            letter-spacing: 0.05em;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, var(--gold-dark) 0%, #6B4F0A 100%);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201,168,76,0.4);
        }
        .btn-noir {
            background: var(--noir);
            color: var(--gold-light);
            font-family: var(--font-ui);
            font-weight: 700;
            letter-spacing: 0.05em;
            border: 1px solid var(--gold-dark);
            transition: all 0.3s ease;
        }
        .btn-noir:hover {
            background: var(--gold);
            color: var(--noir);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201,168,76,0.35);
        }
        .btn-outline-gold {
            border: 2px solid var(--gold);
            color: var(--gold-dark);
            font-family: var(--font-ui);
            font-weight: 700;
            letter-spacing: 0.05em;
            background: transparent;
            transition: all 0.3s ease;
        }
        .btn-outline-gold:hover {
            background: var(--gold);
            color: var(--noir);
            transform: translateY(-2px);
        }

        /* ---- Cards ---- */
        .card-classic {
            background: #fff;
            border: 1px solid var(--cream-border);
            border-radius: 4px;
            box-shadow: 0 2px 20px rgba(13,13,13,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-classic:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(13,13,13,0.12);
        }
        .card-noir {
            background: var(--noir-card);
            border: 1px solid rgba(201,168,76,0.2);
            border-radius: 4px;
            color: #fff;
        }

        /* ---- Form Controls ---- */
        .form-control-classic, .form-select-classic {
            border: 1px solid var(--cream-border);
            border-radius: 2px;
            font-family: var(--font-ui);
            background: #fff;
            color: var(--noir);
            padding: 10px 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control-classic:focus, .form-select-classic:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
            outline: none;
        }

        /* ---- Badges ---- */
        .badge-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: #fff;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 2px;
            letter-spacing: 0.05em;
        }
        .badge-noir {
            background: var(--noir);
            color: var(--gold-light);
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 2px;
        }

        /* ---- Alert Toast ---- */
        .toast-classic {
            border-left: 4px solid var(--gold);
            background: var(--noir-soft);
            color: #fff;
            border-radius: 4px;
        }

        /* ---- Page Transition ---- */
        body { animation: pageFadeIn 0.4s ease; }
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ---- Scroll Reveal ---- */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ---- Alerts ---- */
        .alert-classic-success {
            background: #F0F7F4;
            border: 1px solid #1D4D30;
            border-left: 4px solid #2D7A4F;
            color: var(--noir);
            border-radius: 2px;
        }
        .alert-classic-danger {
            background: #FBF0F2;
            border: 1px solid var(--burgundy);
            border-left: 4px solid var(--burgundy);
            color: var(--noir);
            border-radius: 2px;
        }

        /* ---- Main container ---- */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
    </style>
    @stack('styles')
</head>
<body>

    @include('components.navbar')

    <!-- Flash messages -->
    @if(session('success') || session('error'))
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-classic-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-check-circle" style="color:#2D7A4F"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-classic-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                <i class="fa-solid fa-circle-exclamation" style="color:var(--burgundy)"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    @endif

    <main class="container {{ request()->routeIs('home') ? 'mb-4' : 'my-4' }}" style="flex:1; min-height: 100vh;">
        @yield('content')
    </main>

    <!-- Main Footer Component -->
    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== AGGRESSIVE BROWSER BACK BUTTON PREVENTION =====
        function preventBack() { window.history.forward(); }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) { window.location.reload(); }
        });

        // Scroll Reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
        }, { threshold: 0.1 });
        document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

        // Global CSRF for AJAX
        window.csrfToken = document.querySelector('meta[name=csrf-token]')?.content || '';

        // Global cart badge updater
        function updateCartBadge(count) {
            const badge = document.getElementById('cart-badge-count');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
                if (count > 0) badge.classList.add('badge-pulse');
            }
        }

        // Global toast notification
        function showCartToast(message, type = 'success') {
            const existing = document.getElementById('global-cart-toast');
            if (existing) existing.remove();
            const t = document.createElement('div');
            t.id = 'global-cart-toast';
            t.style.cssText = `
                position:fixed; bottom:28px; right:28px; z-index:9999;
                background:linear-gradient(135deg,#0D0D0D,#1C1C17);
                border-left:4px solid ${type==='success'?'#C9A84C':'#6B2D3E'};
                color:#fff; border-radius:4px; padding:14px 20px;
                font-family:'Lato',sans-serif; font-size:0.85rem;
                box-shadow:0 8px 32px rgba(0,0,0,0.4);
                display:flex; align-items:center; gap:10px;
                animation: toastIn 0.4s cubic-bezier(0.16,1,0.3,1);
                max-width:320px;
            `;
            t.innerHTML = `<i class="fa-solid ${type==='success'?'fa-check-circle':'fa-circle-exclamation'}" style="color:${type==='success'?'#C9A84C':'#FF8A9B'};"></i><span>${message}</span>`;
            document.body.appendChild(t);
            setTimeout(() => { t.style.animation = 'toastOut 0.3s ease forwards'; setTimeout(() => t.remove(), 300); }, 3000);
        }
    </script>
    <style>
        @keyframes toastIn  { from{opacity:0;transform:translateX(40px)} to{opacity:1;transform:translateX(0)} }
        @keyframes toastOut { from{opacity:1;transform:translateX(0)} to{opacity:0;transform:translateX(40px)} }
        @keyframes badgePulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.2)} }
        .badge-pulse { animation: badgePulse 0.4s ease; }
    </style>
    @stack('scripts')
</body>
</html>