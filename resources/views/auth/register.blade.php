@extends('layouts.guest')
@section('title', 'Daftar')
@section('content')

<div class="auth-header">
    <div class="auth-icon">🌱</div>
    <h2 class="auth-title">Buat Akun Baru</h2>
    <p class="auth-subtitle">Bergabung dengan komunitas petani cerdas</p>
</div>

@if($errors->any())
<div class="alert alert-error">
    <span class="alert-icon">⚠️</span>
    {{ $errors->first() }}
</div>
@endif

<form action="{{ route('register.post') }}" method="POST" class="auth-form">
    @csrf

    <div class="form-group">
        <label class="form-label" for="name">Nama Lengkap</label>
        <div class="input-wrapper">
            <span class="input-icon">👤</span>
            <input
                type="text"
                id="name"
                name="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Budi Santoso"
                required
            >
        </div>
        @error('name')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <div class="input-wrapper">
            <span class="input-icon">✉️</span>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                placeholder="budi@email.com"
                required
            >
        </div>
        @error('email')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label">Daftar Sebagai</label>
        <div class="role-options">
            <div class="role-option">
                <input
                    type="radio"
                    name="role"
                    id="r-petani"
                    value="petani"
                    {{ old('role', 'petani') == 'petani' ? 'checked' : '' }}
                >
                <label for="r-petani">
                    <span class="role-icon">👨‍🌾</span>
                    <span class="role-name">Petani</span>
                    <span class="role-desc">Pemilik / penggarap lahan</span>
                </label>
            </div>
            <div class="role-option">
                <input
                    type="radio"
                    name="role"
                    id="r-penyuluh"
                    value="penyuluh"
                    {{ old('role') == 'penyuluh' ? 'checked' : '' }}
                >
                <label for="r-penyuluh">
                    <span class="role-icon">👨‍🏫</span>
                    <span class="role-name">Penyuluh</span>
                    <span class="role-desc">Tenaga pendamping pertanian</span>
                </label>
            </div>
        </div>
        @error('role')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="wilayah">Wilayah / Kabupaten</label>
        <div class="input-wrapper">
            <span class="input-icon">📍</span>
            <input
                type="text"
                id="wilayah"
                name="wilayah"
                class="form-control @error('wilayah') is-invalid @enderror"
                value="{{ old('wilayah') }}"
                placeholder="Semarang, Jawa Tengah"
            >
        </div>
        @error('wilayah')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password">Password</label>
        <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control @error('password') is-invalid @enderror"
                placeholder="Min. 8 karakter"
                required
            >
        </div>
        @error('password')
            <span class="field-error">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
        <div class="input-wrapper">
            <span class="input-icon">🔒</span>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                class="form-control"
                placeholder="Ulangi password"
                required
            >
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-full">
        <span>Buat Akun</span>
        <span class="btn-arrow">→</span>
    </button>
</form>

<div class="auth-divider">
    <span>atau</span>
</div>

<div class="auth-footer">
    Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
</div>

<div class="auth-note">
    🏛️ Akun Dinas Pertanian hanya dapat dibuat oleh administrator.
</div>

@endsection
