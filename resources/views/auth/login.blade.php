@extends('layouts.guest')
@section('title', 'Masuk')
@section('content')

<div class="auth-header">
    <div class="auth-icon">🌾</div>
    <h2 class="auth-title">Masuk ke Akun</h2>
    <p class="auth-subtitle">Selamat datang kembali 👋</p>
</div>

@if($errors->any())
<div class="alert alert-error">
    <span class="alert-icon">⚠️</span>
    {{ $errors->first() }}
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    <span class="alert-icon">✅</span>
    {{ session('success') }}
</div>
@endif

<form action="{{ route('login.post') }}" method="POST" class="auth-form">
    @csrf

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
                placeholder="petani@email.com"
                required
                autofocus
            >
        </div>
        @error('email')
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
                class="form-control"
                placeholder="••••••••"
                required
            >
        </div>
    </div>

    <div class="form-check">
        <input type="checkbox" name="remember" id="remember" class="check-input">
        <label for="remember" class="check-label">Ingat saya</label>
    </div>

    <button type="submit" class="btn btn-primary btn-full">
        <span>Masuk</span>
        <span class="btn-arrow">→</span>
    </button>
</form>

<div class="auth-divider">
    <span>atau</span>
</div>

<div class="auth-footer">
    Belum punya akun? <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
</div>

@endsection
