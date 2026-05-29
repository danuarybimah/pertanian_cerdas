@extends('layouts.app')
@section('title', 'Edit Profil')
@section('content')

<style>
    .profile-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeIn 0.4s ease-out;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-label span {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px 12px 42px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        font-size: 0.95rem;
        color: #1f2937;
        background-color: #f9fafb;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--green-600);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(45, 122, 79, 0.12);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .field-error {
        display: block;
        font-size: 0.8rem;
        color: #ef4444;
        margin-top: 6px;
        font-weight: 500;
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

    .form-control:focus + .input-icon {
        color: var(--green-600);
    }

    .action-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--green-600), var(--green-700));
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-family: inherit;
        font-size: 0.925rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(45, 122, 79, 0.25);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        box-shadow: 0 6px 16px rgba(45, 122, 79, 0.35);
        transform: translateY(-1px);
    }

    .btn-submit:disabled {
        background: #9ca3af;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel {
        background-color: #f3f4f6;
        color: #4b5563;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-family: inherit;
        font-size: 0.925rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }

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

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="page-container" style="max-width: 800px; margin: 0 auto; padding: 24px 16px;">
    <!-- Page Header -->
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 28px;">
        <a href="{{ route('dashboard') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; background-color: #ffffff; border: 1px solid #e5e7eb; color: #4b5563; transition: all 0.2s;" title="Kembali ke beranda">
            <i data-lucide="arrow-left" style="width: 20px; height: 20px;"></i>
        </a>
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Pengaturan Profil</h1>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 2px 0 0;">Perbarui data informasi akun dan kata sandi Anda</p>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
    <div style="margin-bottom: 24px;">
        <div class="alert alert-success" style="padding: 14px 18px; border-radius: 12px; background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; display: flex; gap: 10px; font-size: 0.9rem; align-items: center;">
            <i data-lucide="check-circle" style="width: 20px; height: 20px; flex-shrink: 0; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div style="margin-bottom: 24px;">
        <div class="alert alert-error" style="padding: 14px 18px; border-radius: 12px; background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; display: flex; gap: 10px; font-size: 0.9rem; align-items: center;">
            <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0; color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Profile Form Card -->
    <div class="profile-card">
        <div style="padding: 32px;">
            <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                @csrf

                <div style="font-size: 0.95rem; font-weight: 700; color: var(--green-800); border-bottom: 1px solid #f3f4f6; padding-bottom: 8px; margin-bottom: 20px;">
                    Informasi Pribadi
                </div>

                <div class="grid grid-2">
                    <!-- Nama Lengkap -->
                    <div class="form-group">
                        <label class="form-label" for="name">Nama Lengkap <span>*</span></label>
                        <div class="input-wrapper">
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan nama..."
                                required
                            >
                            <span class="input-icon">
                                <i data-lucide="user"></i>
                            </span>
                        </div>
                        @error('name')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label" for="email">Alamat Email <span>*</span></label>
                        <div class="input-wrapper">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}"
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
                </div>

                <!-- Wilayah -->
                <div class="form-group" style="max-width: 50%;">
                    <label class="form-label" for="wilayah">Wilayah / Kabupaten</label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            name="wilayah"
                            id="wilayah"
                            class="form-control @error('wilayah') is-invalid @enderror"
                            value="{{ old('wilayah', $user->wilayah) }}"
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

                <div style="font-size: 0.95rem; font-weight: 700; color: var(--green-800); border-bottom: 1px solid #f3f4f6; padding-bottom: 8px; margin-top: 36px; margin-bottom: 20px;">
                    Ubah Kata Sandi (Opsional)
                </div>
                <p style="font-size: 0.8rem; color: #9ca3af; margin-top: -12px; margin-bottom: 20px;">* Biarkan kosong jika Anda tidak ingin mengubah kata sandi akun Anda saat ini.</p>

                <div class="grid grid-2">
                    <!-- Sandi Baru -->
                    <div class="form-group">
                        <label class="form-label" for="password">Kata Sandi Baru</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control form-control-password @error('password') is-invalid @enderror"
                                placeholder="Min. 8 karakter"
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

                    <!-- Konfirmasi Sandi Baru -->
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                name="password_confirmation"
                                id="password_confirmation"
                                class="form-control form-control-password"
                                placeholder="Ulangi kata sandi baru"
                            >
                            <span class="input-icon">
                                <i data-lucide="lock-keyhole"></i>
                            </span>
                            <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility('password_confirmation', this)">
                                <i data-lucide="eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="action-row">
                    <a href="{{ route('dashboard') }}" class="btn-cancel">
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i data-lucide="check" style="width: 18px; height: 18px;"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Password visibility toggle
    function togglePasswordVisibility(fieldId, button) {
        const input = document.getElementById(fieldId);
        if (!input) return;

        if (input.type === 'password') {
            input.type = 'text';
            button.innerHTML = '<i data-lucide="eye-off"></i>';
        } else {
            input.type = 'password';
            button.innerHTML = '<i data-lucide="eye"></i>';
        }
        
        lucide.createIcons();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profileForm');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <i data-lucide="loader-2" class="animate-spin" style="width: 18px; height: 18px;"></i>
                    <span>Menyimpan Profil...</span>
                `;
                lucide.createIcons();
            });
        }
        
        // Re-initialize Lucide just in case
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
@endpush
