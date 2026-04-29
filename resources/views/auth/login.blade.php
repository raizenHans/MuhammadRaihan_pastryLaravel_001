<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pegawai — Artorious Pastry</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0D0D0D 0%, #111108 50%, #1C1C17 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Lato', sans-serif;
            position: relative;
            overflow: hidden;
        }

        /* Background ornament */
        body::before {
            content: '';
            position: fixed; inset: 0;
            background-image: radial-gradient(circle, rgba(201,168,76,0.04) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        /* Decorative circles */
        .bg-orb {
            position: fixed;
            border-radius: 50%;
            pointer-events: none;
        }
        .bg-orb-1 {
            width: 500px; height: 500px;
            top: -200px; right: -150px;
            background: radial-gradient(circle, rgba(201,168,76,0.06), transparent 70%);
        }
        .bg-orb-2 {
            width: 400px; height: 400px;
            bottom: -150px; left: -100px;
            background: radial-gradient(circle, rgba(107,45,62,0.08), transparent 70%);
        }

        .login-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 20px;
            animation: loginSlideUp 0.5s cubic-bezier(0.16,1,0.3,1);
        }
        @keyframes loginSlideUp {
            from { opacity:0; transform:translateY(30px); }
            to   { opacity:1; transform:translateY(0); }
        }

        .login-card {
            background: rgba(255,255,255,0.97);
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(201,168,76,0.15);
        }

        .login-header {
            background: linear-gradient(135deg, #0D0D0D, #1C1C17);
            padding: 32px 32px 28px;
            text-align: center;
            position: relative;
        }
        .login-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, #C9A84C, #8B6914, #C9A84C);
        }

        .login-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #C9A84C, #8B6914);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 8px 24px rgba(201,168,76,0.4);
        }

        .login-title {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .login-sub {
            color: rgba(255,255,255,0.45);
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .login-body { padding: 28px 32px 32px; }

        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: #6B6560;
            margin-bottom: 7px;
        }
        .form-input {
            width: 100%;
            border: 1px solid #E2D9CC;
            border-radius: 3px;
            padding: 12px 14px;
            font-family: 'Lato', sans-serif;
            font-size: 0.9rem;
            color: #0D0D0D;
            transition: all 0.3s;
            outline: none;
        }
        .form-input:focus {
            border-color: #C9A84C;
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
        }

        .btn-login {
            width: 100%;
            background: linear-gradient(135deg, #C9A84C, #8B6914);
            color: #fff; border: none;
            padding: 13px;
            border-radius: 3px;
            font-family: 'Lato', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: all 0.3s;
            margin-top: 8px;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #8B6914, #5A4008);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(201,168,76,0.4);
        }
        .btn-login:active { transform: translateY(0); }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 0.06em;
            transition: color 0.3s;
        }
        .back-link:hover { color: #C9A84C; }

        .error-box {
            background: #FBF0F2;
            border: 1px solid #6B2D3E;
            border-left: 4px solid #6B2D3E;
            border-radius: 3px;
            padding: 10px 14px;
            font-size: 0.84rem;
            color: #0D0D0D;
            margin-bottom: 18px;
            display: flex;
            gap: 8px;
            align-items: flex-start;
        }
    </style>
</head>
<body>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>

    <div class="login-wrap">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <img src="{{ asset('images/logo.png') }}" alt="Artorious Logo" style="
                    width: 72px; height: 72px;
                    border-radius: 50%;
                    object-fit: cover;
                    margin: 0 auto 16px;
                    box-shadow: 0 8px 24px rgba(201,168,76,0.4);
                    display: block;
                ">
                <div class="login-title">Login Pegawai</div>
                <div class="login-sub">Sistem Manajemen Artorious Pastry</div>
            </div>

            <!-- Body -->
            <div class="login-body">
                @if($errors->any())
                <div class="error-box">
                    <i class="fa-solid fa-circle-exclamation" style="color:#6B2D3E; margin-top:2px; flex-shrink:0;"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
                @if(session('error'))
                <div class="error-box">
                    <i class="fa-solid fa-circle-exclamation" style="color:#6B2D3E; margin-top:2px; flex-shrink:0;"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-input" placeholder="admin@pastry.com" required
                               value="{{ old('email') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-input" placeholder="••••••••" required>
                    </div>

                    <!-- Gold divider -->
                    <div style="height:1px; background:linear-gradient(90deg,transparent,#E2D9CC,transparent); margin:20px 0;"></div>

                    <button type="submit" class="btn-login">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk Sistem
                    </button>
                </form>
            </div>
        </div>

        <a href="{{ route('home') }}" class="back-link">
            <i class="fa-solid fa-arrow-left" style="margin-right:6px; font-size:0.75rem;"></i> Kembali ke Halaman Utama
        </a>
    </div>

    <script>
        // ===== AGGRESSIVE BROWSER BACK BUTTON PREVENTION =====
        function preventBack() { window.history.forward(); }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) { window.location.reload(); }
        });
    </script>
</body>
</html>