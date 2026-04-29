<div class="sidebar d-flex flex-column">

    <!-- Sidebar Header / Brand -->
    <div style="
        padding: 24px 20px 20px;
        border-bottom: 1px solid rgba(201,168,76,0.15);
        text-align: center;
        background: rgba(201,168,76,0.04);
    ">
        <img src="{{ asset('images/logo.png') }}" alt="Artorious Logo" style="
            width: 52px; height: 52px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 12px;
            box-shadow: 0 4px 16px rgba(201,168,76,0.4);
            display: block;
        ">
        <div style="font-family:'Playfair Display',serif; color:#C9A84C; font-size:1.05rem; font-weight:700; letter-spacing:0.05em;">Artorious Pastry</div>
        <div style="font-size:0.65rem; color:rgba(255,255,255,0.35); letter-spacing:0.2em; text-transform:uppercase; margin-top:3px;">
            @if(Auth::check() && Auth::user()->role === 'admin')
                Sistem Admin
            @else
                Kasir Operator
            @endif
        </div>
    </div>

    <!-- Navigation -->
    <nav style="flex:1; padding: 16px 0; overflow-y: auto;">
        @if(Auth::check() && Auth::user()->role === 'admin')

            <!-- Section: Utama -->
            <div style="padding:8px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Navigasi Utama
            </div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-line"></i> Dashboard Admin
            </a>

            <!-- Section: Katalog -->
            <div style="padding:16px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Katalog Produk
            </div>
            <a href="{{ route('admin.pastries.index') }}" class="sidebar-link {{ request()->routeIs('admin.pastries.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bread-slice"></i> Data Pastry
            </a>
            <a href="{{ route('admin.drinks.index') }}" class="sidebar-link {{ request()->routeIs('admin.drinks.*') ? 'active' : '' }}">
                <i class="fa-solid fa-mug-hot"></i> Data Minuman
            </a>
            <a href="{{ route('admin.promos.index') }}" class="sidebar-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Data Promo
            </a>

            <!-- Section: Pengguna -->
            <div style="padding:16px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Manajemen
            </div>
            <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i> Data Pegawai
            </a>
            <a href="{{ route('admin.members.index') }}" class="sidebar-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                <i class="fa-solid fa-id-card"></i> Data Member
            </a>

            <!-- Section: Loyalty -->
            <div style="padding:16px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Member Loyalty
            </div>
            <a href="{{ route('admin.rewards.index') }}" class="sidebar-link {{ request()->routeIs('admin.rewards.*') ? 'active' : '' }}">
                <i class="fa-solid fa-gift"></i> Kelola Hadiah
            </a>

        @elseif(Auth::check() && Auth::user()->role === 'operator')

            <!-- Section: Utama -->
            <div style="padding:8px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Navigasi Utama
            </div>
            <a href="{{ route('operator.dashboard') }}" class="sidebar-link {{ request()->routeIs('operator.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-desktop"></i> Dashboard Kasir
            </a>

            <!-- Section: Stok -->
            <div style="padding:16px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Inventori
            </div>
            <a href="{{ route('admin.pastries.index') }}" class="sidebar-link {{ request()->routeIs('admin.pastries.*') ? 'active' : '' }}">
                <i class="fa-solid fa-bread-slice"></i> Stok Pastry
            </a>
            <a href="{{ route('admin.drinks.index') }}" class="sidebar-link {{ request()->routeIs('admin.drinks.*') ? 'active' : '' }}">
                <i class="fa-solid fa-mug-hot"></i> Stok Minuman
            </a>
            <a href="{{ route('admin.promos.index') }}" class="sidebar-link {{ request()->routeIs('admin.promos.*') ? 'active' : '' }}">
                <i class="fa-solid fa-tags"></i> Stok Promo
            </a>

            <!-- Section: Transaksi -->
            <div style="padding:16px 20px 4px; font-size:0.62rem; color:rgba(201,168,76,0.5); letter-spacing:0.2em; text-transform:uppercase; font-family:'Lato',sans-serif;">
                ✦ &nbsp; Transaksi
            </div>
            <a href="{{ route('operator.orders') }}" class="sidebar-link {{ request()->routeIs('operator.orders') ? 'active' : '' }}">
                <i class="fa-solid fa-cash-register"></i> Antrean Kasir
                @php $pending = \App\Models\Transaction::where('payment_status','pending')->count() @endphp
                @if($pending > 0)
                    <span style="margin-left:auto; background:linear-gradient(135deg,#C9A84C,#8B6914); color:#fff; font-size:0.65rem; font-weight:700; padding:2px 7px; border-radius:10px;">{{ $pending }}</span>
                @endif
            </a>
            <a href="{{ route('operator.history') }}" class="sidebar-link {{ request()->routeIs('operator.history') ? 'active' : '' }}">
                <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
            </a>
        @endif
    </nav>

    <!-- Logout -->
    <div style="padding:16px; border-top:1px solid rgba(201,168,76,0.12);">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="
                width:100%; background:transparent; border:1.5px solid rgba(107,45,62,0.5);
                color:rgba(255,255,255,0.5); padding:9px 16px; border-radius:3px;
                font-family:'Lato',sans-serif; font-size:0.8rem; font-weight:700;
                letter-spacing:0.06em; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:8px;
                transition:all 0.3s;
            "
            onmouseover="this.style.background='rgba(107,45,62,0.3)'; this.style.color='#fff'; this.style.borderColor='rgba(107,45,62,0.8)';"
            onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.5)'; this.style.borderColor='rgba(107,45,62,0.5)';">
                <i class="fa-solid fa-right-from-bracket"></i> KELUAR SISTEM
            </button>
        </form>
    </div>
</div>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 20px;
        color: rgba(255,255,255,0.55);
        text-decoration: none;
        font-family: 'Lato', sans-serif;
        font-size: 0.84rem;
        font-weight: 400;
        letter-spacing: 0.02em;
        transition: all 0.25s;
        border-left: 3px solid transparent;
        margin: 1px 0;
    }
    .sidebar-link:hover {
        background: rgba(201,168,76,0.08);
        color: #C9A84C;
        border-left-color: rgba(201,168,76,0.4);
    }
    .sidebar-link.active {
        background: rgba(201,168,76,0.12);
        color: #C9A84C;
        font-weight: 700;
        border-left: 3px solid #C9A84C;
    }
    .sidebar-link i {
        width: 18px;
        text-align: center;
        font-size: 0.85rem;
        opacity: 0.8;
    }
    .sidebar-link.active i { opacity: 1; }
</style>
