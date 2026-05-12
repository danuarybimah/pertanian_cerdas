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
    <div class="card mb-6">
        <div class="card-header"><span class="card-title">💰 Input Harga Pasar</span></div>
        <div class="card-body">
            <form action="{{ route('harga-pasar.store') }}" method="POST">
                @csrf
                <div class="grid grid-4">
                    <div class="form-group">
                        <label class="form-label">Komoditas</label>
                        <select name="komoditas_id" class="form-select" required>
                            <option value="">Pilih komoditas</option>
                            @foreach(\App\Models\Komoditas::where('aktif',true)->orderBy('nama')->get() as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Harga (Rp/{{ 'kg' }})</label>
                        <input type="number" name="harga" class="form-control" placeholder="5000" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Lokasi Pasar</label>
                        <input type="text" name="lokasi_pasar" class="form-control" placeholder="Pasar Johar" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Data Harga</button>
            </form>
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
