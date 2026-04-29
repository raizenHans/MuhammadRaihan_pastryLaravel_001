<nav style="
    background: rgba(13,13,13,0.97);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(201,168,76,0.25);
    position: sticky;
    top: 0;
    z-index: 999;
    box-shadow: 0 4px 24px rgba(0,0,0,0.3);
" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}" style="text-decoration:none;">
            <img src="{{ asset('images/logo.png') }}" alt="Artorious Logo" style="height: 38px; width: 38px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(201,168,76,0.3);">
            <div>
                <div style="font-family:'Playfair Display',serif; color:#C9A84C; font-size:1.1rem; font-weight:700; line-height:1.1; letter-spacing:0.05em;">Artorious Pastry</div>
                <div style="font-family:'Lato',sans-serif; color:rgba(255,255,255,0.45); font-size:0.6rem; letter-spacing:0.15em; text-transform:uppercase;">Artisan & Café</div>
            </div>
        </a>

        <!-- Toggler -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" style="color:rgba(201,168,76,0.8);">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('home') }}"
                       style="font-family:'Lato',sans-serif; font-size:0.85rem; letter-spacing:0.08em; text-transform:uppercase; color:{{ request()->routeIs('home') ? '#C9A84C' : 'rgba(255,255,255,0.7)' }}; font-weight:{{ request()->routeIs('home') ? '700' : '400' }}; transition:color 0.3s; border-bottom:{{ request()->routeIs('home') ? '2px solid #C9A84C' : '2px solid transparent' }};">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 py-2" href="{{ route('catalog') }}"
                       style="font-family:'Lato',sans-serif; font-size:0.85rem; letter-spacing:0.08em; text-transform:uppercase; color:{{ request()->routeIs('catalog') ? '#C9A84C' : 'rgba(255,255,255,0.7)' }}; font-weight:{{ request()->routeIs('catalog') ? '700' : '400' }}; transition:color 0.3s; border-bottom:{{ request()->routeIs('catalog') ? '2px solid #C9A84C' : '2px solid transparent' }};">
                        Katalog Menu
                    </a>
                </li>

                @auth
                {{-- Customer history link -- uncomment when route is added --}}
                @endauth

                <!-- Cart -->
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" style="
                        position:relative; display:flex; align-items:center; gap:6px;
                        background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.3);
                        color:#C9A84C; text-decoration:none;
                        padding:7px 14px; border-radius:3px;
                        font-family:'Lato',sans-serif; font-size:0.85rem; font-weight:700; letter-spacing:0.05em;
                        transition:all 0.3s;
                    "
                    onmouseover="this.style.background='rgba(201,168,76,0.25)'"
                    onmouseout="this.style.background='rgba(201,168,76,0.12)'">
                        <i class="fa-solid fa-basket-shopping"></i>
                        Keranjang
                        @php $cartCount = \App\Models\Cart::where('session_id', request()->session()->getId())->sum('quantity') @endphp
                        <span id="cart-badge-count" style="
                            background:linear-gradient(135deg,#C9A84C,#8B6914);
                            color:#fff; font-size:0.7rem; font-weight:700;
                            padding:1px 6px; border-radius:10px; min-width:18px; text-align:center;
                            animation: cartPulse 2s infinite;
                            display: {{ $cartCount > 0 ? 'inline-block' : 'none' }};
                        ">{{ $cartCount }}</span>
                    </a>
                </li>

                <!-- Login/Logout -->
                @guest
                <li class="nav-item">
                    <a href="/login" style="
                        display:inline-flex; align-items:center; gap:6px;
                        border:1.5px solid rgba(201,168,76,0.5); color:rgba(255,255,255,0.7);
                        padding:7px 14px; border-radius:3px; text-decoration:none;
                        font-family:'Lato',sans-serif; font-size:0.8rem; letter-spacing:0.08em; text-transform:uppercase;
                        transition:all 0.3s;
                    "
                    onmouseover="this.style.borderColor='#C9A84C'; this.style.color='#C9A84C';"
                    onmouseout="this.style.borderColor='rgba(201,168,76,0.5)'; this.style.color='rgba(255,255,255,0.7)';">
                        <i class="fa-solid fa-user-tie" style="font-size:0.75rem;"></i> Staff Login
                    </a>
                </li>
                @else
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" style="
                            border:1.5px solid rgba(107,45,62,0.6); color:rgba(255,255,255,0.6);
                            background:transparent; padding:7px 14px; border-radius:3px;
                            font-family:'Lato',sans-serif; font-size:0.8rem; letter-spacing:0.05em; cursor:pointer;
                            transition:all 0.3s;
                        "
                        onmouseover="this.style.background='rgba(107,45,62,0.3)'; this.style.color='#fff';"
                        onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.6)';">
                            <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </button>
                    </form>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
@keyframes cartPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}
</style>
