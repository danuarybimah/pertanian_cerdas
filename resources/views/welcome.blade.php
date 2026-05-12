@extends('layouts.app')
@section('title', 'Beranda')
@section('content')

{{-- HERO --}}
<section class="hero">
    <div class="hero-content animate-in">
        <h1>Portal Pertanian <span>Cerdas</span> untuk Petani Indonesia</h1>
        <p>Data cuaca real-time, harga pasar terkini, panduan bertani, dan konsultasi langsung dengan penyuluh pertanian terpercaya.</p>
        <div class="hero-actions">
            <a href="{{ route('harga-pasar.index') }}" class="btn btn-gold">💰 Cek Harga Pasar</a>
            @guest
            <a href="{{ route('register') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.5);">Daftar Gratis →</a>
            @else
            <a href="{{ route('dashboard') }}" class="btn btn-outline" style="color:white;border-color:rgba(255,255,255,.5);">Dashboard →</a>
            @endguest
        </div>
    </div>
</section>

{{-- DAMPAK STATS --}}
<div class="page-container">
    <div class="grid grid-4 mb-8 animate-in delay-1">
        <div class="stat-card">
            <div class="stat-icon">👨‍🌾</div>
            <div class="stat-value">{{ number_format($dampak['total_petani']) }}</div>
            <div class="stat-label">Petani Terdaftar</div>
        </div>
        <div class="stat-card gold">
            <div class="stat-icon">💰</div>
            <div class="stat-value">{{ number_format($dampak['komoditas_aktif']) }}</div>
            <div class="stat-label">Komoditas Dipantau</div>
        </div>
        <div class="stat-card purple">
            <div class="stat-icon">💬</div>
            <div class="stat-value">{{ number_format($dampak['total_konsultasi']) }}</div>
            <div class="stat-label">Konsultasi Dilayani</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📰</div>
            <div class="stat-value">{{ number_format($dampak['total_artikel']) }}</div>
            <div class="stat-label">Artikel Panduan</div>
        </div>
    </div>

    <div class="grid grid-2 mb-8">
        {{-- HARGA TERKINI --}}
        <div class="card animate-in delay-1">
            <div class="card-header">
                <span class="card-title">💰 Harga Pasar Terkini</span>
                <a href="{{ route('harga-pasar.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body" style="padding:0;">
                @if($harga->count())
                <table class="harga-table">
                    <thead><tr><th>Komoditas</th><th>Harga</th><th>Pasar</th></tr></thead>
                    <tbody>
                    @foreach($harga as $h)
                    <tr>
                        <td><strong>{{ $h->komoditas?->nama ?? '-' }}</strong></td>
                        <td><strong style="color:var(--green-700)">Rp {{ number_format($h->harga,0,',','.') }}</strong>/{{ $h->komoditas?->satuan }}</td>
                        <td style="color:var(--gray-400);font-size:.8rem">{{ $h->lokasi_pasar }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state"><div class="empty-state-icon">📊</div><div>Belum ada data harga</div></div>
                @endif
            </div>
        </div>

        {{-- ARTIKEL TERBARU --}}
        <div class="card animate-in delay-2">
            <div class="card-header">
                <span class="card-title">📰 Artikel Terbaru</span>
                <a href="{{ route('artikel.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:16px;">
                @forelse($artikel as $art)
                <a href="{{ route('artikel.show', $art->slug) }}" style="text-decoration:none;color:inherit;">
                    <div style="display:flex;gap:12px;align-items:flex-start;">
                        <div style="width:48px;height:48px;background:linear-gradient(135deg,var(--green-600),var(--green-400));border-radius:8px;display:grid;place-items:center;font-size:1.3rem;flex-shrink:0;">
                            {{ $art->kategori === 'cuaca' ? '🌤️' : ($art->kategori === 'tips' ? '💡' : '📖') }}
                        </div>
                        <div>
                            <div style="font-size:.7rem;color:var(--green-600);font-weight:700;text-transform:uppercase;margin-bottom:2px;">{{ $art->kategori_label }}</div>
                            <div style="font-weight:600;font-size:.9rem;color:var(--gray-800);">{{ $art->judul }}</div>
                            <div style="font-size:.78rem;color:var(--gray-400);margin-top:2px;">{{ $art->penulis?->name }} · {{ $art->published_at?->diffForHumans() }}</div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-state"><div class="empty-state-icon">📰</div><div>Belum ada artikel</div></div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- FITUR UNGGULAN --}}
    <div class="mb-8">
        <h2 class="section-title text-center">🌟 Fitur Unggulan</h2>
        <div class="grid grid-3">
            <div class="card animate-in delay-1" style="border-top:3px solid var(--green-500);">
                <div class="card-body text-center">
                    <div style="font-size:3rem;margin-bottom:12px;">🌤️</div>
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:8px;color:var(--green-800);">Info Cuaca Real-time</h3>
                    <p style="font-size:.875rem;color:var(--gray-600);">Data cuaca akurat berbasis lokasi wilayah Anda. Ramalan 7 hari ke depan dengan rekomendasi kegiatan pertanian.</p>
                </div>
            </div>
            <div class="card animate-in delay-2" style="border-top:3px solid var(--gold-500);">
                <div class="card-body text-center">
                    <div style="font-size:3rem;margin-bottom:12px;">📅</div>
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:8px;color:var(--green-800);">Kalender Tanam Cerdas</h3>
                    <p style="font-size:.875rem;color:var(--gray-600);">Panduan waktu tanam optimal berdasarkan musim dan jenis komoditas untuk memaksimalkan hasil panen.</p>
                </div>
            </div>
            <div class="card animate-in delay-3" style="border-top:3px solid #7c3aed;">
                <div class="card-body text-center">
                    <div style="font-size:3rem;margin-bottom:12px;">💬</div>
                    <h3 style="font-size:1rem;font-weight:700;margin-bottom:8px;color:var(--green-800);">Forum Konsultasi</h3>
                    <p style="font-size:.875rem;color:var(--gray-600);">Tanya langsung ke penyuluh pertanian berpengalaman. Dapatkan solusi tepat untuk masalah di lahan Anda.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    @guest
    <div style="background:linear-gradient(135deg,var(--green-800),var(--green-600));border-radius:var(--radius-xl);padding:48px;text-align:center;color:white;margin-bottom:40px;">
        <h2 style="font-size:1.8rem;font-weight:800;margin-bottom:12px;">Bergabung Sekarang — Gratis!</h2>
        <p style="opacity:.85;margin-bottom:24px;">Daftar dan akses semua fitur untuk mendukung keberhasilan pertanian Anda.</p>
        <a href="{{ route('register') }}" class="btn btn-gold" style="font-size:1rem;padding:14px 32px;">Daftar Sekarang →</a>
    </div>
    @endguest
</div>
@endsection
