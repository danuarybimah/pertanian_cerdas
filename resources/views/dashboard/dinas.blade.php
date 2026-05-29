@extends('layouts.app')
@section('title', 'Dashboard Dinas')
@section('content')
<div class="page-container">
    <div class="page-header">
        <h1 class="page-title">🏛️ Dashboard Dinas Pertanian</h1>
        <p class="page-subtitle">Pantau semua data pertanian & statistik dampak program</p>
    </div>

    <div class="grid grid-4 mb-6">
        <div class="stat-card"><div class="stat-icon">👨‍🌾</div><div class="stat-value">{{ $statistik['total_petani'] }}</div><div class="stat-label">Total Petani</div></div>
        <div class="stat-card gold"><div class="stat-icon">💬</div><div class="stat-value">{{ $statistik['total_konsultasi'] }}</div><div class="stat-label">Total Konsultasi</div></div>
        <div class="stat-card purple"><div class="stat-icon">✅</div><div class="stat-value">{{ $statistik['konsultasi_selesai'] }}</div><div class="stat-label">Konsultasi Selesai</div></div>
        <div class="stat-card red"><div class="stat-icon">📰</div><div class="stat-value">{{ $statistik['total_artikel'] }}</div><div class="stat-label">Artikel Diterbitkan</div></div>
    </div>

    <div class="grid grid-3 mb-6">
        <div class="stat-card" style="background:linear-gradient(135deg,var(--green-700),var(--green-500));color:white;border:none;">
            <div style="font-size:.85rem;opacity:.8;margin-bottom:4px;">Estimasi Produktivitas Rata-rata</div>
            <div style="font-size:2.5rem;font-weight:800;">{{ number_format($statistik['produktivitas_est'],1) }} <span style="font-size:1rem;font-weight:500;">ton/ha</span></div>
        </div>
        <div class="stat-card gold" style="background:linear-gradient(135deg,var(--gold-600),var(--gold-400));color:var(--brown-800);border:none;">
            <div style="font-size:.85rem;opacity:.8;margin-bottom:4px;">Perubahan Harga 7 Hari</div>
            <div style="font-size:2.5rem;font-weight:800;">
                {{ $statistik['kenaikan_harga_pct'] > 0 ? '▲' : ($statistik['kenaikan_harga_pct'] < 0 ? '▼' : '—') }}
                {{ abs($statistik['kenaikan_harga_pct']) }}%
            </div>
        </div>
        <div class="stat-card" style="background:linear-gradient(135deg,#5b21b6,#7c3aed);color:white;border:none;">
            <div style="font-size:.85rem;opacity:.8;margin-bottom:4px;">Total Views Artikel</div>
            <div style="font-size:2.5rem;font-weight:800;">{{ number_format($statistik['total_views_artikel']) }}</div>
        </div>
    </div>

    <div class="grid grid-2 mb-6">
        <div class="card">
            <div class="card-header"><span class="card-title">📈 Tren Konsultasi Bulanan</span></div>
            <div class="card-body"><canvas id="grafikKonsultasi" height="200"></canvas></div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">💬 Konsultasi Terbaru</span>
                <a href="{{ route('konsultasi.index') }}" class="btn btn-outline btn-sm">Semua</a>
            </div>
            <div class="card-body" style="display:flex;flex-direction:column;gap:8px;max-height:280px;overflow-y:auto;">
                @foreach($allKonsultasi->getCollection()->take(6) as $k)
                <a href="{{ route('konsultasi.show', $k->id) }}" style="text-decoration:none;display:flex;justify-content:space-between;align-items:center;padding:10px;border:1px solid var(--gray-100);border-radius:var(--radius-sm);">
                    <div>
                        <div style="font-weight:600;font-size:.875rem;">{{ Str::limit($k->judul,40) }}</div>
                        <div style="font-size:.75rem;color:var(--gray-400);">{{ $k->petani?->name }} · {{ $k->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="badge badge-{{ $k->status_color }}">{{ $k->status_label }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- INPUT HARGA PASAR --}}
    <div class="card mb-6" style="background: linear-gradient(135deg, #f0faf4 0%, #ffffff 100%); border-left: 5px solid var(--green-600); border-radius: 16px;">
        <div class="card-body" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 24px 32px;">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: var(--green-800); margin: 0; display: flex; align-items: center; gap: 8px;">
                    💰 Input Harga Pasar Komoditas
                </h3>
                <p style="font-size: 0.85rem; color: var(--gray-600); margin: 4px 0 0;">Catat dan publikasikan harga komoditas pangan dari berbagai pasar sekaligus.</p>
            </div>
            <a href="{{ route('harga-pasar.create') }}" class="btn btn-primary" style="border-radius: 12px; padding: 12px 24px; box-shadow: 0 4px 12px rgba(45, 122, 79, 0.2); display: flex; align-items: center; gap: 8px;">
                <i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i>
                <span>Mulai Input Harga</span>
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('grafikKonsultasi'), {
    type: 'line',
    data: {
        labels: @json($grafikKonsultasi['labels']),
        datasets: [{
            label: 'Konsultasi',
            data: @json($grafikKonsultasi['values']),
            borderColor: '#2d7a4f', backgroundColor: 'rgba(45,122,79,.1)',
            fill: true, tension: 0.4, pointRadius: 5,
        }]
    },
    options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
});
</script>
@endpush
@endsection
