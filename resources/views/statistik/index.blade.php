@extends('layouts.app')
@section('title', 'Statistik Dampak')
@section('content')
<div class="page-container">
    <div class="page-header"><h1 class="page-title">📊 Statistik & Dampak Program</h1><p class="page-subtitle">Pengukuran dampak nyata sistem informasi pertanian</p></div>

    <div class="grid grid-4 mb-6">
        <div class="stat-card"><div class="stat-icon">👨‍🌾</div><div class="stat-value">{{ number_format($dampak['total_petani']) }}</div><div class="stat-label">Total Petani</div></div>
        <div class="stat-card gold"><div class="stat-icon">👨‍🏫</div><div class="stat-value">{{ number_format($dampak['total_penyuluh']) }}</div><div class="stat-label">Penyuluh Aktif</div></div>
        <div class="stat-card purple"><div class="stat-icon">💬</div><div class="stat-value">{{ number_format($dampak['total_konsultasi']) }}</div><div class="stat-label">Total Konsultasi</div></div>
        <div class="stat-card"><div class="stat-icon">✅</div><div class="stat-value">{{ number_format($dampak['konsultasi_selesai']) }}</div><div class="stat-label">Konsultasi Selesai</div></div>
    </div>

    <div class="grid grid-3 mb-6">
        <div style="background:linear-gradient(135deg,var(--green-800),var(--green-600));border-radius:var(--radius-lg);padding:28px;color:white;text-align:center;">
            <div style="font-size:3rem;margin-bottom:6px;">🌾</div>
            <div style="font-size:2.2rem;font-weight:800;">{{ number_format($dampak['produktivitas_est'],1) }} ton/ha</div>
            <div style="opacity:.8;font-size:.875rem;margin-top:4px;">Estimasi Produktivitas Rata-rata</div>
        </div>
        <div style="background:linear-gradient(135deg,var(--gold-600),var(--gold-400));border-radius:var(--radius-lg);padding:28px;color:var(--brown-800);text-align:center;">
            <div style="font-size:3rem;margin-bottom:6px;">💰</div>
            <div style="font-size:2.2rem;font-weight:800;">{{ $dampak['kenaikan_harga_pct'] > 0 ? '+' : '' }}{{ $dampak['kenaikan_harga_pct'] }}%</div>
            <div style="opacity:.7;font-size:.875rem;margin-top:4px;">Perubahan Harga 7 Hari</div>
        </div>
        <div style="background:linear-gradient(135deg,#5b21b6,#7c3aed);border-radius:var(--radius-lg);padding:28px;color:white;text-align:center;">
            <div style="font-size:3rem;margin-bottom:6px;">📰</div>
            <div style="font-size:2.2rem;font-weight:800;">{{ number_format($dampak['total_views_artikel']) }}</div>
            <div style="opacity:.8;font-size:.875rem;margin-top:4px;">Total Pembaca Artikel</div>
        </div>
    </div>

    <div class="grid grid-2 mb-6">
        <div class="card">
            <div class="card-header"><span class="card-title">📈 Tren Konsultasi Bulanan</span></div>
            <div class="card-body"><canvas id="grafikKonsultasi" height="200"></canvas></div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">💰 Tren Harga Komoditas</span>
                <form method="GET" style="display:flex;gap:8px;align-items:center;">
                    <select name="komoditas_id" class="form-select" style="width:150px;padding:6px;" onchange="this.form.submit()">
                        @foreach($komoditas as $k)<option value="{{ $k->id }}" {{ $selectedKomoditas == $k->id ? 'selected':'' }}>{{ $k->nama }}</option>@endforeach
                    </select>
                </form>
            </div>
            <div class="card-body"><canvas id="grafikHarga" height="200"></canvas></div>
        </div>
    </div>

    @if($petaniPerWilayah->count())
    <div class="card">
        <div class="card-header"><span class="card-title">🗺️ Distribusi Petani per Wilayah</span></div>
        <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
            @foreach($petaniPerWilayah as $pw)
            <div style="display:flex;align-items:center;gap:12px;">
                <div style="width:140px;font-size:.85rem;font-weight:600;color:var(--gray-700);">{{ $pw->wilayah ?? 'Tidak diisi' }}</div>
                <div style="flex:1;background:var(--gray-100);border-radius:4px;height:20px;overflow:hidden;">
                    <div style="height:100%;background:linear-gradient(90deg,var(--green-600),var(--green-400));border-radius:4px;width:{{ min(($pw->total / max($petaniPerWilayah->max('total'), 1)) * 100, 100) }}%;transition:width .6s;"></div>
                </div>
                <div style="width:30px;font-size:.85rem;font-weight:700;color:var(--green-700);">{{ $pw->total }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('grafikKonsultasi'), {
    type: 'bar',
    data: { labels: @json($grafikKonsultasi['labels']), datasets: [{ label:'Konsultasi', data: @json($grafikKonsultasi['values']), backgroundColor:'rgba(45,122,79,.7)', borderColor:'#2d7a4f', borderWidth:2, borderRadius:6 }] },
    options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true,ticks:{stepSize:1}}} }
});
@if(count($grafikHarga['labels']))
new Chart(document.getElementById('grafikHarga'), {
    type: 'line',
    data: { labels: @json($grafikHarga['labels']), datasets: [{ label:'Harga (Rp)', data: @json($grafikHarga['values']), borderColor:'#d4a017', backgroundColor:'rgba(212,160,23,.1)', fill:true, tension:0.4, pointRadius:4 }] },
    options: { responsive:true, plugins:{legend:{display:false}, tooltip:{callbacks:{label:ctx=>'Rp '+ctx.raw.toLocaleString('id-ID')}}}, scales:{y:{ticks:{callback:v=>'Rp '+Number(v).toLocaleString('id-ID')}}} }
});
@endif
</script>
@endpush
@endsection
