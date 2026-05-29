<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication') — SIPertani</title>
    
    <!-- Google Fonts & Lucide Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    @vite(['resources/css/app.css'])

    <style>
        :root {
            --primary-green: #1e5c38;
            --light-green: #2d7a4f;
            --accent-gold: #d4a017;
            --dark-bg: #0b1e13;
            --glass-white: rgba(255, 255, 255, 0.88);
            --border-glass: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--dark-bg);
            background-image: 
                radial-gradient(at 0% 0%, rgba(30, 92, 56, 0.3) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(212, 160, 23, 0.15) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(13, 40, 24, 0.9) 0px, transparent 50%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow-x: hidden;
            position: relative;
        }

        /* Ambient Glow Blobs */
        .glow-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }

        .glow-circle {
            position: absolute;
            border-radius: 50%;
            filter: blur(100px);
            opacity: 0.25;
            mix-blend-mode: screen;
        }

        .glow-circle-1 {
            top: 15%;
            left: 10%;
            width: 350px;
            height: 350px;
            background: #3a9a64;
        }

        .glow-circle-2 {
            bottom: 15%;
            right: 10%;
            width: 400px;
            height: 400px;
            background: #d4a017;
        }

        /* Glassmorphic Auth Card */
        .auth-card {
            background: var(--glass-white);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-glass);
            border-radius: 24px;
            box-shadow: 
                0 4px 30px rgba(0, 0, 0, 0.2),
                0 20px 50px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            padding: 44px 40px;
            width: 100%;
            max-width: 460px;
            position: relative;
            z-index: 10;
            animation: authFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon-wrapper {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, var(--light-green), var(--primary-green));
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(30, 92, 56, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.2);
            color: #ffffff;
            margin-bottom: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-icon {
            width: 26px;
            height: 26px;
        }

        .auth-brand h1 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #111827;
            margin-top: 4px;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .auth-brand h1 span {
            color: var(--primary-green);
        }

        .auth-brand p {
            color: #4b5563;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 4px;
        }

        /* Animations */
        @keyframes authFadeIn {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Utility classes */
        .text-primary-green {
            color: var(--primary-green);
        }
    </style>
</head>
<body>
    <!-- Background Glow Elements -->
    <div class="glow-bg">
        <div class="glow-circle glow-circle-1"></div>
        <div class="glow-circle glow-circle-2"></div>
    </div>

    <!-- Main Content Card -->
    <div class="auth-card">
        <div class="auth-brand">
            <div class="logo-icon-wrapper">
                <i data-lucide="sprout" class="logo-icon"></i>
            </div>
            <h1>SI<span>Pertani</span></h1>
            <p>Sistem Informasi Pertanian Cerdas</p>
        </div>
        
        @yield('content')
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
    
    @stack('scripts')
</body>
</html>
