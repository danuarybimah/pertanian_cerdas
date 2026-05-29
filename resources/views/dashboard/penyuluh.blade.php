@extends('layouts.app')
@section('title', 'Dashboard Penyuluh')
@section('content')
<div class="page-container">
    <div class="page-header">
        <h1 class="page-title">👨‍🏫 Dashboard Penyuluh</h1>
        <p class="page-subtitle">Kelola konsultasi & artikel untuk membantu petani</p>
    </div>

    <div class="grid grid-4 mb-6">
        <div class="stat-card"><div class="stat-icon">⏳</div><div class="stat-value">{{ $konsultasiOpen->where('status', 'open')->count() }}</div><div class="stat-label">Menunggu Jawaban</div></div>
        <div class="stat-card gold"><div class="stat-icon">📰</div><div class="stat-value">{{ $artikelSaya->count() }}</div><div class="stat-label">Artikel Saya</div></div>
        <div class="stat-card purple"><div class="stat-icon">👥</div><div class="stat-value">{{ $statistik['total_petani'] }}</div><div class="stat-label">Total Petani</div></div>
        <div class="stat-card"><div class="stat-icon">💬</div><div class="stat-value">{{ $statistik['total_konsultasi'] }}</div><div class="stat-label">Total Konsultasi</div></div>
    </div>

    <div class="grid grid-2 mb-6">
        {{-- CUACA --}}
        <div class="cuaca-widget">
            <div style="font-size:.8rem;opacity:.75;margin-bottom:6px;">📍 {{ $cuaca['wilayah'] }}</div>
            <div class="cuaca-main">
                <div class="cuaca-icon">{{ $cuaca['ikon'] }}</div>
                <div><div class="cuaca-temp">{{ $cuaca['suhu'] }}°C</div><div class="cuaca-desc">{{ $cuaca['deskripsi'] }}</div></div>
            </div>
            <div class="cuaca-forecast">
                @foreach(array_slice($cuaca['forecast'], 0, 5) as $fc)
                <div class="forecast-item">
                    <div class="forecast-day">{{ substr($fc['hari'],0,3) }}</div>
                    <div class="forecast-icon">{{ $fc['ikon'] }}</div>
                    <div class="forecast-temp">{{ $fc['suhu_max'] }}°/{{ $fc['suhu_min'] }}°</div>
                </div>
                @endforeach
            </div>
            <div class="cuaca-rekomendasi">{{ $cuaca['rekomendasi'] }}</div>
        </div>

        {{-- GRAFIK KONSULTASI --}}
        <div class="card">
            <div class="card-header"><span class="card-title">📊 Tren Konsultasi 6 Bulan</span></div>
            <div class="card-body"><canvas id="grafikKonsultasi" height="180"></canvas></div>
        </div>
    </div>

    <div class="grid grid-2">
        {{-- KONSULTASI MENUNGGU --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">💬 Diskusi Konsultasi Aktif</span>
                <a href="{{ route('konsultasi.index') }}" class="btn btn-outline btn-sm">Semua</a>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                @forelse($konsultasiOpen->take(5) as $k)
                <a href="{{ route('konsultasi.show', $k->id) }}" style="text-decoration:none;">
                    <div class="konsultasi-item">
                        <div class="flex-between mb-2">
                            <div class="konsultasi-title">{{ Str::limit($k->judul,45) }}</div>
                            <span class="badge badge-{{ $k->status_color }}">{{ $k->status_label }}</span>
                        </div>
                        <div class="konsultasi-meta">
                            <span>👤 {{ $k->petani?->name }}</span>
                            <span>🌿 {{ $k->tanaman ?? 'Umum' }}</span>
                            <span>🕐 {{ $k->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="empty-state"><div class="empty-state-icon">✅</div><div>Tidak ada konsultasi aktif.</div></div>
                @endforelse
            </div>
        </div>

        {{-- ARTIKEL SAYA --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">📰 Artikel Saya</span>
                <a href="{{ route('artikel.create') }}" class="btn btn-primary btn-sm">+ Tulis</a>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                @forelse($artikelSaya->take(5) as $art)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;border:1px solid var(--gray-100);border-radius:var(--radius-sm);">
                    <div>
                        <div style="font-weight:600;font-size:.875rem;">{{ Str::limit($art->judul,40) }}</div>
                        <div style="font-size:.75rem;color:var(--gray-400);">👁️ {{ $art->views }} views · {{ $art->created_at->format('d M Y') }}</div>
                    </div>
                    <div style="display:flex;gap:6px;align-items:center;">
                        <span class="badge {{ $art->published ? 'badge-success' : 'badge-secondary' }}">{{ $art->published ? 'Publik' : 'Draft' }}</span>
                        <a href="{{ route('artikel.edit', $art->id) }}" class="btn btn-outline btn-sm">Edit</a>
                    </div>
                </div>
                @empty
                <div class="empty-state"><div class="empty-state-icon">✏️</div><div>Belum ada artikel</div><a href="{{ route('artikel.create') }}" class="btn btn-primary btn-sm mt-4">Tulis Sekarang</a></div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('grafikKonsultasi'), {
    type: 'bar',
    data: {
        labels: @json($grafikKonsultasi['labels']),
        datasets: [{
            label: 'Jumlah Konsultasi',
            data: @json($grafikKonsultasi['values']),
            backgroundColor: 'rgba(45,122,79,.7)',
            borderColor: 'rgba(45,122,79,1)',
            borderWidth: 2, borderRadius: 6,
        }]
    },
    options: { responsive:true, plugins:{ legend:{display:false} }, scales:{ y:{beginAtZero:true, ticks:{stepSize:1}} } }
});
</script>
@endpush
@endsection
