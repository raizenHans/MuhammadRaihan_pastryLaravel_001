<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page_title', 'Kasir Operator') — Artorious Pastry</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Cormorant+Garamond:wght@300;400;500&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
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
            --noir-sidebar: #111108;
            --noir-card:    #1C1C17;
            --warm-gray:    #6B6560;
            --burgundy:     #6B2D3E;
            --success-dark: #1D4D30;
            --font-heading: 'Playfair Display', Georgia, serif;
            --font-body:    'Cormorant Garamond', Georgia, serif;
            --font-ui:      'Lato', sans-serif;
            --sidebar-w:    260px;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-ui);
            background-color: #F2EFE9;
            color: var(--noir);
            display: flex;
            min-height: 100vh;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--noir-sidebar);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            border-right: 1px solid rgba(201,168,76,0.15);
            box-shadow: 4px 0 24px rgba(0,0,0,0.4);
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: #fff;
            border-bottom: 1px solid var(--cream-border);
            padding: 14px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky; top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(13,13,13,0.06);
        }
        .topbar-title {
            font-family: var(--font-heading);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--noir);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .topbar-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 20px;
            background: linear-gradient(var(--gold), var(--gold-dark));
            border-radius: 2px;
        }

        /* ===== PAGE CONTENT ===== */
        .page-content {
            padding: 28px 32px;
            flex: 1;
        }

        /* ===== BUTTONS ===== */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            color: #fff; border: none;
            font-family: var(--font-ui); font-weight: 700;
            letter-spacing: 0.04em;
            transition: all 0.3s;
        }
        .btn-gold:hover {
            background: linear-gradient(135deg, var(--gold-dark) 0%, #5A4008 100%);
            color: #fff; transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(201,168,76,0.4);
        }
        .btn-noir {
            background: var(--noir); color: var(--gold-light);
            border: 1px solid rgba(201,168,76,0.4);
            font-family: var(--font-ui); font-weight: 700;
            transition: all 0.3s;
        }
        .btn-noir:hover {
            background: var(--gold); color: var(--noir); transform: translateY(-1px);
        }
        .btn-outline-gold {
            border: 1.5px solid var(--gold); color: var(--gold-dark);
            font-family: var(--font-ui); font-weight: 700;
            background: transparent; transition: all 0.3s;
        }
        .btn-outline-gold:hover {
            background: var(--gold); color: var(--noir);
        }

        /* ===== CARDS ===== */
        .card { border-radius: 6px; }
        .card-stat {
            border: none;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(13,13,13,0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card-stat:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(13,13,13,0.14);
        }

        /* ===== TABLE ===== */
        .table-classic thead th {
            background: var(--noir-card);
            color: var(--gold-light);
            font-family: var(--font-ui);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.1em;
            border: none;
            padding: 14px 16px;
        }
        .table-classic tbody tr {
            border-bottom: 1px solid var(--cream-border);
            transition: background 0.2s;
        }
        .table-classic tbody tr:hover {
            background-color: var(--gold-pale);
        }
        .table-classic tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        /* ===== FORM ===== */
        .form-control, .form-select {
            border: 1px solid var(--cream-border);
            border-radius: 3px;
            font-family: var(--font-ui);
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.18);
        }
        .form-label { font-weight: 700; font-size: 0.85rem; color: var(--warm-gray); letter-spacing: 0.04em; }

        /* ===== BADGE ===== */
        .badge-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: #fff; font-weight: 700;
            padding: 4px 10px; border-radius: 2px;
            font-size: 0.72rem; letter-spacing: 0.05em;
        }

        /* ===== ALERTS ===== */
        .alert-success {
            background: #F0F7F4 !important;
            border: 1px solid #1D4D30 !important;
            border-left: 4px solid #2D7A4F !important;
            color: var(--noir) !important;
        }
        .alert-danger {
            background: #FBF0F2 !important;
            border: 1px solid var(--burgundy) !important;
            border-left: 4px solid var(--burgundy) !important;
            color: var(--noir) !important;
        }

        /* ===== PAGE TRANSITION ===== */
        .page-content { animation: fadeIn 0.35s ease; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== PENDING PULSE ===== */
        @keyframes pendingPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }
        .badge-pending { animation: pendingPulse 2s infinite; }
    </style>
    @stack('styles')
</head>
<body>

    @include('components.sidebar')

    <div class="content-area">
        <!-- Topbar -->
        <div class="topbar">
            <div class="topbar-title">
                <i class="fa-solid fa-cash-register" style="color:var(--gold); font-size:0.9rem"></i>
                @yield('page_title', 'Kasir Operator')
            </div>
            <div class="d-flex align-items-center gap-3">
                <div id="live-clock" style="font-family:var(--font-ui); font-size:0.85rem; color:var(--warm-gray); font-weight:700;"></div>
                <div class="d-flex align-items-center gap-2">
                    <div style="width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,var(--gold),var(--gold-dark)); display:flex; align-items:center; justify-content:center;">
                        <i class="fa-solid fa-user" style="color:#fff; font-size:0.8rem;"></i>
                    </div>
                    <div>
                        <div style="font-size:0.85rem; font-weight:700; line-height:1.2;">{{ Auth::user()->name ?? 'Operator' }}</div>
                        <div style="font-size:0.72rem; color:var(--warm-gray); text-transform:uppercase; letter-spacing:0.08em;">Kasir</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <div class="px-4 pt-3">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="fa-solid fa-check-circle" style="color:#2D7A4F"></i>
                    <span>{{ session('success') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
                    <i class="fa-solid fa-circle-exclamation" style="color:var(--burgundy)"></i>
                    <span>{{ session('error') }}</span>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Main Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ===== AGGRESSIVE BROWSER BACK BUTTON PREVENTION =====
        function preventBack() { window.history.forward(); }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) { window.location.reload(); }
        });

        // Live Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('live-clock').textContent =
                now.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit', second:'2-digit'}) +
                ' — ' + now.toLocaleDateString('id-ID', {weekday:'short', day:'numeric', month:'short'});
        }
        updateClock();
        setInterval(updateClock, 1000);

        // Chart.js Global
        Chart.defaults.font.family = "'Lato', sans-serif";
        Chart.defaults.color = '#6B6560';
    </script>
    @stack('scripts')
</body>
</html>