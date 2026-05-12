@extends('layouts.app')
@section('title', 'Harga Pasar')
@section('content')
<div class="page-container">
    <div class="page-header flex-between">
        <div><h1 class="page-title">💰 Harga Pasar Terkini</h1><p class="page-subtitle">Data harga komoditas pertanian hari ini</p></div>
    </div>

    {{-- HARGA TERKINI CARDS --}}
    <div class="grid grid-4 mb-6">
        @foreach($hargaTerkini->take(8) as $h)
        <div class="stat-card" style="cursor:pointer;" onclick="window.location='?komoditas_id={{ $h->komoditas_id }}'">
            <div style="font-size:.75rem;color:var(--gray-400);font-weight:600;text-transform:uppercase;margin-bottom:4px;">{{ $h->komoditas?->nama }}</div>
            <div style="font-size:1.5rem;font-weight:800;color:var(--green-700);">Rp {{ number_format($h->harga,0,',','.') }}</div>
            <div style="font-size:.75rem;color:var(--gray-400);">per {{ $h->komoditas?->satuan }} · {{ $h->lokasi_pasar }}</div>
            <div style="font-size:.7rem;margin-top:4px;color:var(--gray-400);">{{ \Carbon\Carbon::parse($h->tanggal)->format('d M Y') }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-2">
        {{-- GRAFIK TREN --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title">📈 Tren Harga 30 Hari</span>
                <form method="GET" style="display:flex;gap:8px;align-items:center;">
                    <select name="komoditas_id" class="form-select" style="width:160px;padding:6px 10px;" onchange="this.form.submit()">
                        @foreach($komoditas as $k)
                        <option value="{{ $k->id }}" {{ $selected == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="card-body"><canvas id="grafikHarga" height="200"></canvas></div>
        </div>

        {{-- TABEL RIWAYAT --}}
        <div class="card">
            <div class="card-header"><span class="card-title">📋 Riwayat Harga</span></div>
            <div style="overflow:auto;max-height:340px;">
                @if($riwayat->count())
                <table class="harga-table">
                    <thead><tr><th>Tanggal</th><th>Harga</th><th>Min</th><th>Max</th><th>Pasar</th></tr></thead>
                    <tbody>
                    @foreach($riwayat->reverse() as $r)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M') }}</td>
                        <td><strong>Rp {{ number_format($r->harga,0,',','.') }}</strong></td>
                        <td style="font-size:.8rem;color:var(--gray-400);">{{ $r->harga_min ? 'Rp '.number_format($r->harga_min,0,',','.') : '-' }}</td>
                        <td style="font-size:.8rem;color:var(--gray-400);">{{ $r->harga_max ? 'Rp '.number_format($r->harga_max,0,',','.') : '-' }}</td>
                        <td style="font-size:.8rem;color:var(--gray-400);">{{ $r->lokasi_pasar }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state"><div class="empty-state-icon">📊</div><div>Pilih komoditas untuk melihat riwayat</div></div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = @json($grafikData['labels']);
const values = @json($grafikData['values']);
if (labels.length) {
    new Chart(document.getElementById('grafikHarga'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Harga (Rp)',
                data: values,
                borderColor: '#2d7a4f', backgroundColor: 'rgba(45,122,79,.1)',
                fill: true, tension: 0.4, pointRadius: 4, pointHoverRadius: 7,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') } } },
            scales: { y: { ticks: { callback: v => 'Rp ' + Number(v).toLocaleString('id-ID') } } }
        }
    });
}
</script>
@endpush
@endsection
