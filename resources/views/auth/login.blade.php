@extends('layouts.guest')
@section('title', 'Masuk')
@section('content')

<style>
    /* Focus & Input custom styles */
    .form-group {
        margin-bottom: 22px;
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
        margin-bottom: 7px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        pointer-events: none;
        transition: color 0.2s ease;
    }

    .input-icon svg {
        width: 18px;
        height: 18px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        font-size: 0.925rem;
        font-family: inherit;
        color: #1f2937;
        background-color: #f9fafb;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-green);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(30, 92, 56, 0.12);
    }

    .form-control:focus + .input-icon {
        color: var(--primary-green);
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .field-error {
        display: block;
        font-size: 0.78rem;
        color: #ef4444;
        margin-top: 5px;
        font-weight: 500;
    }

    /* Password visibility toggle button */
    .toggle-password-btn {
        position: absolute;
        right: 14px;
        background: none;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        display: flex;
        align-items: center;
        padding: 4px;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .toggle-password-btn:hover {
        color: #4b5563;
        background-color: #f3f4f6;
    }

    .toggle-password-btn svg {
        width: 18px;
        height: 18px;
    }

    .form-control-password {
        padding-right: 44px;
    }

    /* Flex container for label/forgot password link */
    .flex-between {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .forgot-link {
        color: var(--light-green);
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .forgot-link:hover {
        color: var(--primary-green);
        text-decoration: underline;
    }

    /* Custom modern Checkbox */
    .checkbox-container {
        display: flex;
        align-items: center;
        position: relative;
        padding-left: 28px;
        margin-bottom: 24px;
        cursor: pointer;
        font-size: 0.875rem;
        color: #4b5563;
        font-weight: 500;
        user-select: none;
    }

    .checkbox-container input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    .checkmark {
        position: absolute;
        top: 2px;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #f3f4f6;
        border: 2px solid #e5e7eb;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .checkbox-container:hover input ~ .checkmark {
        border-color: var(--light-green);
    }

    .checkbox-container input:checked ~ .checkmark {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
    }

    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    .checkbox-container input:checked ~ .checkmark:after {
        display: block;
    }

    .checkbox-container .checkmark:after {
        left: 5px;
        top: 2px;
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    /* Buttons */
    .btn-submit {
        background: linear-gradient(135deg, var(--light-green), var(--primary-green));
        color: #ffffff;
        width: 100%;
        padding: 13px 20px;
        border-radius: 12px;
        border: none;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(30, 92, 56, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.25s ease;
    }

    .btn-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(30, 92, 56, 0.3);
        opacity: 0.95;
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
    }

    /* Spinner Animation */
    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Bottom Divider & Footer */
    .auth-footer-text {
        text-align: center;
        margin-top: 24px;
        font-size: 0.875rem;
        color: #4b5563;
        font-weight: 500;
    }

    .auth-footer-text a {
        color: var(--primary-green);
        font-weight: 700;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .auth-footer-text a:hover {
        color: var(--light-green);
        text-decoration: underline;
    }
</style>

<div style="margin-bottom: 24px; text-align: center;">
    <h2 style="font-size: 1.35rem; font-weight: 700; color: #111827; margin-bottom: 6px;">Selamat Datang Kembali</h2>
    <p style="font-size: 0.85rem; color: #6b7280; font-weight: 500; margin: 0;">Silakan masuk menggunakan akun Anda</p>
</div>

@if($errors->any())
<div class="alert alert-error animate-in" style="padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;">
    <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

@if(session('success'))
<div class="alert alert-success animate-in" style="padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;">
    <i data-lucide="check-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="alert alert-error animate-in" style="padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;">
    <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
    <span>{{ session('error') }}</span>
</div>
@endif

<form action="{{ route('login.post') }}" method="POST" id="loginForm">
    @csrf

    <!-- Email Field -->
    <div class="form-group">
        <label class="form-label" for="email">Alamat Email</label>
        <div class="input-wrapper">
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
                autofocus
            >
            <span class="input-icon">
                <i data-lucide="mail"></i>
            </span>
        </div>
        @error('email')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password Field -->
    <div class="form-group">
        <div class="flex-between">
            <label class="form-label" for="password">Kata Sandi</label>
            <a href="#" class="forgot-link" onclick="alert('Silakan hubungi staf Dinas Pertanian atau Administrator untuk mereset kata sandi Anda.')">Lupa Sandi?</a>
        </div>
        <div class="input-wrapper">
            <input
                type="password"
                id="password"
                name="password"
                class="form-control form-control-password"
                placeholder="••••••••"
                required
            >
            <span class="input-icon">
                <i data-lucide="lock"></i>
            </span>
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password', this)">
                <i data-lucide="eye"></i>
            </button>
        </div>
    </div>

    <!-- Remember Me Checkbox -->
    <label class="checkbox-container">
        Ingat saya di perangkat ini
        <input type="checkbox" name="remember" id="remember">
        <span class="checkmark"></span>
    </label>

    <!-- Submit Button -->
    <button type="submit" class="btn-submit" id="submitBtn">
        <span>Masuk Sekarang</span>
        <i data-lucide="arrow-right" style="width: 18px; height: 18px;"></i>
    </button>
</form>

<div style="display: flex; align-items: center; gap: 12px; margin: 24px 0 16px;">
    <div style="flex: 1; height: 1px; background-color: #e5e7eb;"></div>
    <span style="font-size: 0.78rem; color: #9ca3af; font-weight: 600; text-transform: uppercase;">atau</span>
    <div style="flex: 1; height: 1px; background-color: #e5e7eb;"></div>
</div>

<div class="auth-footer-text">
    Belum terdaftar? <a href="{{ route('register') }}">Buat Akun Baru</a>
</div>

@endsection

@push('scripts')
<script>
    // Password visibility toggle
    function togglePasswordVisibility(fieldId, button) {
        const input = document.getElementById(fieldId);
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = '<i data-lucide="eye-off"></i>';
        } else {
            input.type = 'password';
            button.innerHTML = '<i data-lucide="eye"></i>';
        }
        
        // Re-initialize only the button icon
        lucide.createIcons();
    }

    // Submit loading state
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <i data-lucide="loader-2" class="animate-spin" style="width: 18px; height: 18px;"></i>
                    <span>Memproses Masuk...</span>
                `;
                lucide.createIcons();
            });
        }
    });
</script>
@endpush
