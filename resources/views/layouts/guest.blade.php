<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') — SIPertani</title>
    @vite(['resources/css/app.css'])
    <style>
        body { background: linear-gradient(135deg, var(--green-900) 0%, var(--green-700) 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .auth-card { background: white; border-radius: var(--radius-xl); box-shadow: 0 20px 60px rgba(0,0,0,.3); padding: 40px; width: 100%; max-width: 440px; }
        .auth-brand { text-align: center; margin-bottom: 32px; }
        .auth-brand .logo { font-size: 2.5rem; }
        .auth-brand h1 { font-size: 1.5rem; font-weight: 800; color: var(--green-800); margin-top: 8px; }
        .auth-brand p { color: var(--gray-400); font-size: .875rem; }
        .auth-footer { text-align: center; margin-top: 20px; font-size: .875rem; color: var(--gray-600); }
        .auth-footer a { color: var(--green-600); font-weight: 600; text-decoration: none; }
        .auth-footer a:hover { text-decoration: underline; }
        .role-options { display: grid; grid-template-columns: repeat(2,1fr); gap: 10px; margin-top: 6px; }
        .role-option { position: relative; }
        .role-option input[type="radio"] { position: absolute; opacity: 0; }
        .role-option label {
            display: flex; flex-direction: column; align-items: center; gap: 4px;
            padding: 12px 8px; border: 2px solid var(--gray-200); border-radius: var(--radius-sm);
            cursor: pointer; font-size: .8rem; font-weight: 600; color: var(--gray-600);
            transition: all .2s; text-align: center;
        }
        .role-option label .role-icon { font-size: 1.5rem; }
        .role-option input:checked + label { border-color: var(--green-500); background: var(--green-50); color: var(--green-700); }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-brand">
            <div class="logo">🌾</div>
            <h1>SIPertani</h1>
            <p>Sistem Informasi Pertanian Cerdas</p>
        </div>
        @yield('content')
    </div>
</body>
</html>
