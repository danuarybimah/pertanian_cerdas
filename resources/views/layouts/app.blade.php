<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Pertanian Cerdas - Portal data cuaca & pasar untuk petani lokal">
    <title>@yield('title', 'Pertanian Cerdas') — SIPertani</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar { width: 240px; background: var(--green-800); min-height: calc(100vh - 64px); padding: 20px 0; flex-shrink: 0; }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 24px; color: rgba(255,255,255,.75); text-decoration: none; font-size: .9rem; font-weight: 500; transition: all .2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,.12); color: white; }
        .sidebar-nav a .nav-icon { font-size: 1.1rem; width: 20px; text-align: center; }
        .sidebar-section { padding: 12px 24px 4px; font-size: .7rem; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: 1px; }
        .main-layout { display: flex; min-height: calc(100vh - 64px); }
        .main-content { flex: 1; overflow-x: hidden; }
        @media(max-width: 768px) { .sidebar { display: none; } }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="navbar-brand">
            <div class="logo-icon">🌾</div>
            <span>SIPertani</span>
        </a>
        <div class="navbar-menu" style="display:none" id="nav-menu">
            <a href="{{ route('harga-pasar.index') }}" class="{{ request()->routeIs('harga-pasar*') ? 'active' : '' }}">Harga Pasar</a>
            <a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel*') ? 'active' : '' }}">Artikel</a>
            <a href="{{ route('kalender-tanam.index') }}" class="{{ request()->routeIs('kalender*') ? 'active' : '' }}">Kalender Tanam</a>
        </div>
        <div class="navbar-actions">
            @auth
                <span class="role-badge {{ auth()->user()->role }}">{{ auth()->user()->role_label }}</span>
                <span style="color:rgba(255,255,255,.8);font-size:.9rem;font-weight:500;">{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-outline btn-sm" style="color:rgba(255,255,255,.8);border-color:rgba(255,255,255,.3);">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="color:white;border-color:rgba(255,255,255,.4);">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-gold btn-sm">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<div class="main-layout">
    {{-- SIDEBAR (auth only) --}}
    @auth
    <aside class="sidebar">
        <nav class="sidebar-nav">
            <div class="sidebar-section">Utama</div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
            <a href="{{ route('statistik.index') }}" class="{{ request()->routeIs('statistik*') ? 'active' : '' }}">
                <span class="nav-icon">📊</span> Statistik
            </a>

            <div class="sidebar-section">Informasi</div>
            <a href="{{ route('harga-pasar.index') }}" class="{{ request()->routeIs('harga-pasar*') ? 'active' : '' }}">
                <span class="nav-icon">💰</span> Harga Pasar
            </a>
            <a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel.index') ? 'active' : '' }}">
                <span class="nav-icon">📰</span> Artikel
            </a>
            <a href="{{ route('kalender-tanam.index') }}" class="{{ request()->routeIs('kalender*') ? 'active' : '' }}">
                <span class="nav-icon">📅</span> Kalender Tanam
            </a>

            <div class="sidebar-section">Komunitas</div>
            <a href="{{ route('konsultasi.index') }}" class="{{ request()->routeIs('konsultasi*') ? 'active' : '' }}">
                <span class="nav-icon">💬</span> Konsultasi
            </a>

            @if(auth()->user()->isPenyuluh() || auth()->user()->isDinas())
            <div class="sidebar-section">Kelola</div>
            <a href="{{ route('artikel.create') }}" class="{{ request()->routeIs('artikel.create') ? 'active' : '' }}">
                <span class="nav-icon">✏️</span> Tulis Artikel
            </a>
            @endif
        </nav>
    </aside>
    @endauth

    <main class="main-content">
        @if(session('success'))
            <div style="padding: 12px 32px 0;">
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div style="padding: 12px 32px 0;">
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            </div>
        @endif

        @yield('content')
    </main>
</div>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">🌾 SIPertani</div>
                <p class="footer-desc">Sistem Informasi Pertanian Cerdas — portal berbasis data cuaca & pasar untuk mendukung produktivitas petani lokal Indonesia.</p>
            </div>
            <div>
                <div class="footer-title">Menu</div>
                <ul class="footer-links">
                    <li><a href="{{ route('harga-pasar.index') }}">Harga Pasar</a></li>
                    <li><a href="{{ route('artikel.index') }}">Artikel</a></li>
                    <li><a href="{{ route('kalender-tanam.index') }}">Kalender Tanam</a></li>
                    @auth<li><a href="{{ route('konsultasi.index') }}">Konsultasi</a></li>@endauth
                </ul>
            </div>
            <div>
                <div class="footer-title">Akun</div>
                <ul class="footer-links">
                    @guest
                        <li><a href="{{ route('login') }}">Masuk</a></li>
                        <li><a href="{{ route('register') }}">Daftar</a></li>
                    @else
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('statistik.index') }}">Statistik</a></li>
                    @endguest
                </ul>
            </div>
        </div>
        <div class="footer-bottom">© {{ date('Y') }} SIPertani — Sistem Informasi Pertanian Cerdas. Dikembangkan untuk mendukung petani lokal Indonesia.</div>
    </div>
</footer>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(a => setTimeout(() => a.style.opacity = '0', 4000));
});
</script>

@stack('scripts')
</body>
</html>
