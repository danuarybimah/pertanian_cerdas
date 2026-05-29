<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Pertanian Cerdas - Portal data cuaca & pasar untuk petani lokal">
    <title>@yield('title', 'Pertanian Cerdas') — SIPertani</title>
    
    <!-- Google Fonts & Lucide Icons CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Anti-geser responsif */
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .main-layout {
            max-width: 100%;
            overflow-x: hidden;
        }

        @media (max-width: 768px) {
            .navbar-menu {
                display: none !important;
            }
        }

        .sidebar { width: 240px; background: var(--green-800); min-height: calc(100vh - 64px); padding: 20px 0; flex-shrink: 0; }
        .sidebar-nav a { display: flex; align-items: center; gap: 10px; padding: 10px 24px; color: rgba(255,255,255,.75); text-decoration: none; font-size: .9rem; font-weight: 500; transition: all .2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: rgba(255,255,255,.12); color: white; }
        .sidebar-nav a .nav-icon { font-size: 1.1rem; width: 20px; text-align: center; }
        .sidebar-section { padding: 12px 24px 4px; font-size: .7rem; font-weight: 700; color: rgba(255,255,255,.4); text-transform: uppercase; letter-spacing: 1px; }
        .main-layout { display: flex; min-height: calc(100vh - 64px); }
        .main-content { flex: 1; overflow-x: hidden; }
        @media(max-width: 768px) { .sidebar { display: none; } }

        /* Dropdown Profile Styling */
        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown-btn {
            background: none;
            border: none;
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 12px;
            transition: background-color 0.2s;
            font-family: inherit;
        }

        .profile-dropdown-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .profile-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95);
        }

        .dropdown-chevron {
            width: 16px;
            height: 16px;
            color: rgba(255, 255, 255, 0.7);
            transition: transform 0.2s;
        }

        .profile-dropdown.open .dropdown-chevron {
            transform: rotate(180deg);
        }

        .profile-dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            width: 220px;
            padding: 8px;
            display: none;
            flex-direction: column;
            z-index: 110;
            animation: dropdownFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .profile-dropdown.open .profile-dropdown-menu {
            display: flex;
        }

        .profile-dropdown-menu a, .dropdown-logout-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            color: var(--gray-800);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 10px;
            transition: all 0.2s;
            cursor: pointer;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            font-family: inherit;
        }

        .profile-dropdown-menu a:hover, .dropdown-logout-btn:hover {
            background-color: var(--green-50);
            color: var(--green-700);
        }

        .dropdown-logout-btn {
            color: var(--red-500);
        }

        .dropdown-logout-btn:hover {
            background-color: #fef2f2;
            color: #b91c1c;
        }

        .dropdown-divider {
            border: none;
            border-top: 1px solid var(--gray-200);
            margin: 6px 0;
        }

        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }
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
        <div class="navbar-menu" id="nav-menu" style="@auth @if(!auth()->user()->isPetani()) display:none; @endif @endauth">
            @auth
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('konsultasi.index') }}" class="{{ request()->routeIs('konsultasi*') ? 'active' : '' }}">Konsultasi</a>
            @endauth
            <a href="{{ route('harga-pasar.index') }}" class="{{ request()->routeIs('harga-pasar*') ? 'active' : '' }}">Harga Pasar</a>
            <a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel*') ? 'active' : '' }}">Artikel</a>
            <a href="{{ route('kalender-tanam.index') }}" class="{{ request()->routeIs('kalender*') ? 'active' : '' }}">Kalender Tanam</a>
        </div>
        <div class="navbar-actions">
            @auth
                <div class="profile-dropdown">
                    <button class="profile-dropdown-btn" id="profileDropdownBtn">
                        <span class="role-badge {{ auth()->user()->role }}">{{ auth()->user()->role_label }}</span>
                        <span class="profile-name">{{ auth()->user()->name }}</span>
                        <i data-lucide="chevron-down" class="dropdown-chevron"></i>
                    </button>
                    <div class="profile-dropdown-menu" id="profileDropdownMenu">
                        @if(auth()->user()->isPetani())
                            <a href="{{ route('dashboard') }}"><i data-lucide="home"></i> Beranda</a>
                            <a href="{{ route('konsultasi.index') }}"><i data-lucide="message-square"></i> Konsultasi</a>
                            <a href="{{ route('harga-pasar.index') }}"><i data-lucide="banknote"></i> Harga Pasar</a>
                            <a href="{{ route('kalender-tanam.index') }}"><i data-lucide="calendar"></i> Kalender Tanam</a>
                            <a href="{{ route('artikel.index') }}"><i data-lucide="book-open"></i> Artikel</a>
                            <hr class="dropdown-divider">
                        @endif
                        
                        <a href="{{ route('profile.edit') }}"><i data-lucide="user"></i> Edit Profil</a>
                        
                        <form action="{{ route('logout') }}" method="POST" style="display: block; margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-logout-btn">
                                <i data-lucide="log-out"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="color:white;border-color:rgba(255,255,255,.4);">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-gold btn-sm">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<div class="main-layout">
    {{-- SIDEBAR (auth only, but not for Petani) --}}
    @auth
    @if(!auth()->user()->isPetani())
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

            @if(auth()->user()->isDinas())
            <div class="sidebar-section">Administrasi</div>
            <a href="{{ route('dinas.users.index') }}" class="{{ request()->routeIs('dinas.users*') ? 'active' : '' }}">
                <span class="nav-icon">👥</span> Kelola Pengguna
            </a>
            @endif
        </nav>
    </aside>
    @endif
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
document.addEventListener('DOMContentLoaded', () => {
    // Dropdown toggle logic
    const dropdown = document.querySelector('.profile-dropdown');
    const dropdownBtn = document.getElementById('profileDropdownBtn');
    
    if (dropdownBtn && dropdown) {
        dropdownBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('open');
        });
        document.addEventListener('click', () => {
            dropdown.classList.remove('open');
        });
    }

    // Initialize lucide
    if (window.lucide) {
        lucide.createIcons();
    }

    // Existing alert animation
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(a => setTimeout(() => a.style.opacity = '0', 4000));
});
</script>

@stack('scripts')
</body>
</html>
