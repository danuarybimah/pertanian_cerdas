@extends('layouts.app')
@section('title', 'Dashboard Petani')
@section('content')
<div class="page-container">
    <div class="page-header flex-between">
        <div>
            <h1 class="page-title">👨‍🌾 Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="page-subtitle">{{ now()->format('l, d F Y') }} · {{ auth()->user()->wilayah }}</p>
        </div>
    </div>

    <div class="grid grid-4 mb-6">
        <div class="stat-card"><div class="stat-icon">💬</div><div class="stat-value">{{ $konsultasi->count() }}</div><div class="stat-label">Konsultasi Saya</div></div>
        <div class="stat-card gold"><div class="stat-icon">✅</div><div class="stat-value">{{ $konsultasi->where('status','answered')->count() }}</div><div class="stat-label">Sudah Dijawab</div></div>
        <div class="stat-card"><div class="stat-icon">📰</div><div class="stat-value">{{ $statistik['total_artikel'] }}</div><div class="stat-label">Artikel Tersedia</div></div>
        <div class="stat-card purple"><div class="stat-icon">👨‍🏫</div><div class="stat-value">{{ $statistik['total_penyuluh'] }}</div><div class="stat-label">Penyuluh Aktif</div></div>
    </div>

    <div class="grid grid-2 mb-6">
        {{-- CUACA --}}
        <div class="cuaca-widget">
            <div style="font-size:.8rem;opacity:.75;margin-bottom:6px;">📍 {{ $cuaca['wilayah'] }} · {{ $cuaca['updated_at'] }}</div>
            <div class="cuaca-main">
                <div class="cuaca-icon">{{ $cuaca['ikon'] }}</div>
                <div>
                    <div class="cuaca-temp">{{ $cuaca['suhu'] }}°C</div>
                    <div class="cuaca-desc">{{ $cuaca['deskripsi'] }}</div>
                </div>
            </div>
            <div class="cuaca-details">
                <div class="cuaca-detail-item"><div class="cuaca-detail-value">{{ $cuaca['kelembapan'] }}%</div><div class="cuaca-detail-label">Kelembapan</div></div>
                <div class="cuaca-detail-item"><div class="cuaca-detail-value">{{ $cuaca['hujan'] }}mm</div><div class="cuaca-detail-label">Curah Hujan</div></div>
                <div class="cuaca-detail-item"><div class="cuaca-detail-value">{{ $cuaca['angin'] }}km/h</div><div class="cuaca-detail-label">Kecepatan Angin</div></div>
            </div>
            <div class="cuaca-forecast">
                @foreach(array_slice($cuaca['forecast'], 0, 5) as $fc)
                <div class="forecast-item">
                    <div class="forecast-day">{{ substr($fc['hari'],0,3) }}</div>
                    <div class="forecast-icon">{{ $fc['ikon'] }}</div>
                    <div class="forecast-temp">{{ $fc['suhu_max'] }}°</div>
                </div>
                @endforeach
            </div>
            <div class="cuaca-rekomendasi">{{ $cuaca['rekomendasi'] }}</div>
        </div>

        {{-- HARGA PASAR --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">💰 Harga Pasar Hari Ini</span>
                <a href="{{ route('harga-pasar.index') }}" class="btn btn-outline btn-sm">Selengkapnya</a>
            </div>
            <div style="overflow:auto;max-height:340px;">
                @if($harga->count())
                <table class="harga-table">
                    <thead><tr><th>Komoditas</th><th>Harga/kg</th><th>Pasar</th></tr></thead>
                    <tbody>
                    @foreach($harga as $h)
                    <tr>
                        <td><strong>{{ $h->komoditas?->nama }}</strong></td>
                        <td style="color:var(--green-700);font-weight:700;">Rp {{ number_format($h->harga,0,',','.') }}</td>
                        <td style="font-size:.8rem;color:var(--gray-400);">{{ $h->lokasi_pasar }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state"><div class="empty-state-icon">📊</div><div>Belum ada data harga hari ini</div></div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-2">
        {{-- KONSULTASI SAYA --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">💬 Konsultasi Saya</span>
                <a href="{{ route('konsultasi.create') }}" class="btn btn-primary btn-sm">+ Baru</a>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:12px;">
                @forelse($konsultasi->take(4) as $k)
                <a href="{{ route('konsultasi.show', $k->id) }}" style="text-decoration:none;">
                    <div class="konsultasi-item">
                        <div class="flex-between mb-2">
                            <div class="konsultasi-title">{{ $k->judul }}</div>
                            <span class="badge badge-{{ $k->status_color }}">{{ $k->status_label }}</span>
                        </div>
                        <div class="konsultasi-meta">
                            <span>🌿 {{ $k->tanaman ?? 'Umum' }}</span>
                            <span>💬 {{ $k->jawaban->count() }} jawaban</span>
                            <span>🕐 {{ $k->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-state">
                    <div class="empty-state-icon">💬</div>
                    <div class="empty-state-text">Belum ada konsultasi</div>
                    <a href="{{ route('konsultasi.create') }}" class="btn btn-primary btn-sm mt-4">Buat Konsultasi</a>
                </div>
                @endforelse
            </div>
        </div>

        {{-- ARTIKEL TERBARU --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">📰 Artikel Terbaru</span>
                <a href="{{ route('artikel.index') }}" class="btn btn-outline btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:14px;">
                @forelse($artikel as $art)
                <a href="{{ route('artikel.show', $art->slug) }}" style="text-decoration:none;color:inherit;">
                    <div style="display:flex;gap:12px;align-items:flex-start;padding:10px;border-radius:var(--radius-sm);transition:background .2s;" onmouseover="this.style.background='var(--green-50)'" onmouseout="this.style.background=''">
                        <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--green-600),var(--green-400));border-radius:8px;display:grid;place-items:center;font-size:1.2rem;flex-shrink:0;">📖</div>
                        <div>
                            <div style="font-size:.7rem;color:var(--green-600);font-weight:700;text-transform:uppercase;">{{ $art->kategori_label }}</div>
                            <div style="font-weight:600;font-size:.875rem;">{{ Str::limit($art->judul, 50) }}</div>
                            <div style="font-size:.75rem;color:var(--gray-400);">{{ $art->penulis?->name }}</div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-state"><div class="empty-state-icon">📰</div><div>Belum ada artikel</div></div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
