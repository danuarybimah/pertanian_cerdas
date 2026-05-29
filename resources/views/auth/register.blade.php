@extends('layouts.guest')
@section('title', 'Daftar')
@section('content')

<style>
    /* Focus & Input custom styles */
    .form-group {
        margin-bottom: 20px;
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

    /* Role selection cards grid */
    .role-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-top: 4px;
    }

    .role-card-wrapper {
        cursor: pointer;
        display: block;
        position: relative;
    }

    .role-card-wrapper input[type="radio"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .role-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 16px 12px;
        border: 2px solid #e5e7eb;
        background-color: #f9fafb;
        border-radius: 16px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .role-card-wrapper:hover .role-card {
        border-color: var(--light-green);
        background-color: #f4faf6;
    }

    .role-icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #e5e7eb;
        color: #4b5563;
        margin-bottom: 10px;
        transition: all 0.25s ease;
    }

    .role-icon-circle svg {
        width: 20px;
        height: 20px;
    }

    .role-title {
        font-weight: 700;
        font-size: 0.9rem;
        color: #1f2937;
        display: block;
        transition: color 0.25s ease;
    }

    .role-description {
        font-size: 0.72rem;
        color: #6b7280;
        margin-top: 3px;
        display: block;
        line-height: 1.2;
    }

    /* Active/Checked Role Card styling */
    .role-card-wrapper input[type="radio"]:checked + .role-card {
        border-color: var(--primary-green);
        background-color: #f0fdf4;
        box-shadow: 0 8px 20px rgba(30, 92, 56, 0.1);
    }

    .role-card-wrapper input[type="radio"]:checked + .role-card .role-icon-circle {
        background-color: var(--primary-green);
        color: #ffffff;
    }

    .role-card-wrapper input[type="radio"]:checked + .role-card .role-title {
        color: var(--primary-green);
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
        margin-top: 8px;
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
    <h2 style="font-size: 1.35rem; font-weight: 700; color: #111827; margin-bottom: 6px;">Bergabung Bersama Kami</h2>
    <p style="font-size: 0.85rem; color: #6b7280; font-weight: 500; margin: 0;">Silakan lengkapi formulir pendaftaran di bawah</p>
</div>

@if($errors->any())
<div class="alert alert-error animate-in" style="padding: 12px 16px; border-radius: 10px; font-size: 0.85rem; margin-bottom: 20px; display: flex; align-items: center; gap: 8px; background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c;">
    <i data-lucide="alert-circle" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

<form action="{{ route('register.post') }}" method="POST" id="registerForm">
    @csrf

    <!-- Name Field -->
    <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <div class="input-wrapper">
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Budi Santoso"
                required
                autofocus
            >
            <span class="input-icon">
                <i data-lucide="user"></i>
            </span>
        </div>
        @error('name')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

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
            >
            <span class="input-icon">
                <i data-lucide="mail"></i>
            </span>
        </div>
        @error('email')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <!-- Role Cards Field -->
    <div class="form-group">
        <label class="form-label">Daftar Sebagai</label>
        <div class="role-grid">
            <!-- Petani Card -->
            <label class="role-card-wrapper">
                <input
                    type="radio"
                    name="role"
                    id="r-petani"
                    value="petani"
                    {{ old('role', 'petani') == 'petani' ? 'checked' : '' }}
                    required
                >
                <div class="role-card">
                    <div class="role-icon-circle">
                        <i data-lucide="sprout"></i>
                    </div>
                    <span class="role-title">Petani</span>
                    <span class="role-description">Pemilik / Penggarap Lahan</span>
                </div>
            </label>

            <!-- Penyuluh Card -->
            <label class="role-card-wrapper">
                <input
                    type="radio"
                    name="role"
                    id="r-penyuluh"
                    value="penyuluh"
                    {{ old('role') == 'penyuluh' ? 'checked' : '' }}
                    required
                >
                <div class="role-card">
                    <div class="role-icon-circle">
                        <i data-lucide="graduation-cap"></i>
                    </div>
                    <span class="role-title">Penyuluh</span>
                    <span class="role-description">Tenaga Pendamping Lapangan</span>
                </div>
            </label>
        </div>
        @error('role')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <!-- Wilayah Field -->
    <div class="form-group">
        <label class="form-label" for="wilayah">Wilayah / Kabupaten</label>
        <div class="input-wrapper">
            <input
                type="text"
                id="wilayah"
                name="wilayah"
                class="form-control @error('wilayah') is-invalid @enderror"
                value="{{ old('wilayah') }}"
                placeholder="Semarang, Jawa Tengah"
            >
            <span class="input-icon">
                <i data-lucide="map-pin"></i>
            </span>
        </div>
        @error('wilayah')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password Field -->
    <div class="form-group">
        <label class="form-label" for="password">Kata Sandi</label>
        <div class="input-wrapper">
            <input
                type="password"
                id="password"
                name="password"
                class="form-control form-control-password @error('password') is-invalid @enderror"
                placeholder="Min. 8 karakter"
                required
            >
            <span class="input-icon">
                <i data-lucide="lock"></i>
            </span>
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password', this)">
                <i data-lucide="eye"></i>
            </button>
        </div>
        @error('password')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password Confirmation Field -->
    <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
        <div class="input-wrapper">
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control form-control-password"
                placeholder="Ulangi kata sandi"
                required
            >
            <span class="input-icon">
                <i data-lucide="lock-keyhole"></i>
            </span>
            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                <i data-lucide="eye"></i>
            </button>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn-submit" id="submitBtn">
        <span>Buat Akun Baru</span>
        <i data-lucide="user-plus" style="width: 18px; height: 18px;"></i>
    </button>
</form>

<div style="display: flex; align-items: center; gap: 12px; margin: 24px 0 16px;">
    <div style="flex: 1; height: 1px; background-color: #e5e7eb;"></div>
    <span style="font-size: 0.78rem; color: #9ca3af; font-weight: 600; text-transform: uppercase;">atau</span>
    <div style="flex: 1; height: 1px; background-color: #e5e7eb;"></div>
</div>

<div class="auth-footer-text">
    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
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
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <i data-lucide="loader-2" class="animate-spin" style="width: 18px; height: 18px;"></i>
                    <span>Memproses Pendaftaran...</span>
                `;
                lucide.createIcons();
            });
        }
    });
</script>
@endpush
