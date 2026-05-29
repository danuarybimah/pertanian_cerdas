@extends('layouts.app')
@section('title', 'Kalender Tanam')
@section('content')
<div class="page-container">
    <div class="page-header flex-between">
        <div>
            <h1 class="page-title">📅 Kalender Tanam</h1>
            <p class="page-subtitle">Panduan waktu tanam optimal berdasarkan musim dan komoditas</p>
        </div>
        @auth
            @if(auth()->user()->role == 'dinas' || auth()->user()->role == 'penyuluh')
                <a href="{{ route('kalender-tanam.create') }}" class="btn btn-primary">Tambah Kalender Tanam</a>
            @endif
        @endauth
    </div>

    @php
    $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $warnaBulan = ['','#1a4a2e','#1e5c38','#2d7a4f','#3a9a64','#52b67a','#7dcf9e','#7dcf9e','#52b67a','#3a9a64','#2d7a4f','#1e5c38','#1a4a2e'];
    $komoditasWarna = ['#ef4444','#f97316','#eab308','#22c55e','#3b82f6','#8b5cf6','#ec4899','#14b8a6'];
    @endphp

    {{-- NAVIGASI BULAN --}}
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:28px;">
        @for($b = 1; $b <= 12; $b++)
        <a href="{{ route('kalender-tanam.index', ['bulan' => $b]) }}"
           style="padding:8px 16px;border-radius:20px;font-size:.85rem;font-weight:600;text-decoration:none;transition:all .2s;
                  background:{{ $bulan == $b ? $warnaBulan[$b] : 'white' }};
                  color:{{ $bulan == $b ? 'white' : 'var(--gray-600)' }};
                  border:2px solid {{ $bulan == $b ? $warnaBulan[$b] : 'var(--gray-200)' }};">
            {{ $namaBulan[$b] }}
        </a>
        @endfor
    </div>

    {{-- BULAN TERPILIH --}}
    <div class="card mb-6" style="border-top:4px solid {{ $warnaBulan[$bulan] }};">
        <div class="card-header" style="background:linear-gradient(135deg,{{ $warnaBulan[$bulan] }},{{ $warnaBulan[$bulan < 12 ? $bulan+1 : 1] }});color:white;">
            <span style="font-size:1.1rem;font-weight:700;">📅 {{ $namaBulan[$bulan] }} — Komoditas yang Bisa Ditanam</span>
        </div>
        @if($kalender->count())
        <div class="card-body">
            <div class="grid grid-3">
                @foreach($kalender as $i => $kt)
                <div style="background:var(--green-50);border-radius:var(--radius-md);padding:20px;border-left:4px solid {{ $komoditasWarna[$i % count($komoditasWarna)] }};">
                    <div style="font-size:1.2rem;font-weight:800;color:var(--green-800);margin-bottom:4px;">{{ $kt->komoditas?->nama }}</div>
                    <div style="font-size:.8rem;color:var(--gray-600);margin-bottom:8px;">{{ $kt->komoditas?->kategori_label }}</div>
                    <div style="font-size:.85rem;display:flex;flex-direction:column;gap:4px;">
                        <div>🌱 Tanam: <strong>{{ $kt->bulan_tanam_label }}</strong></div>
                        <div>🌾 Panen: <strong>±{{ $namaBulan[$kt->bulan_panen] ?? '-' }}</strong></div>
                        <div>⏱️ Durasi: <strong>{{ $kt->durasi_tanam }} hari</strong></div>
                        @if($kt->varietas)<div>🌿 Varietas: <strong>{{ $kt->varietas }}</strong></div>@endif
                        @if($kt->produktivitas_rata)<div>📊 Produktivitas: <strong>{{ $kt->produktivitas_rata }} ton/ha</strong></div>@endif
                        <div>🌧️ Musim: <span class="badge badge-{{ $kt->musim === 'hujan' ? 'info' : ($kt->musim === 'kemarau' ? 'warning' : 'success') }}">{{ ucfirst($kt->musim) }}</span></div>
                    </div>
                    @if($kt->keterangan)
                    <p style="font-size:.78rem;color:var(--gray-600);margin-top:8px;font-style:italic;">{{ $kt->keterangan }}</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @else
        <div class="card-body empty-state"><div class="empty-state-icon">🌱</div><div>Tidak ada komoditas yang direkomendasikan bulan ini</div></div>
        @endif
    </div>

    {{-- OVERVIEW 12 BULAN --}}
    <h2 class="section-title">🗓️ Kalender Tanam Sepanjang Tahun</h2>
    <div class="kalender-grid">
        @for($b = 1; $b <= 12; $b++)
        <div class="kalender-bulan {{ $bulan == $b ? 'active' : '' }}">
            <a href="{{ route('kalender-tanam.index', ['bulan'=>$b]) }}" style="text-decoration:none;">
                <div class="kalender-bulan-header" style="background:{{ $warnaBulan[$b] }};">{{ $namaBulan[$b] }}</div>
            </a>
            <div class="kalender-bulan-body">
                @if(isset($overview[$b]) && $overview[$b]->count())
                    @foreach($overview[$b]->take(4) as $i => $kt)
                    <div class="kalender-item">
                        <div class="kalender-item-dot" style="background:{{ $komoditasWarna[$i % count($komoditasWarna)] }};"></div>
                        <span style="font-size:.78rem;">{{ $kt->komoditas?->nama }}</span>
                    </div>
                    @endforeach
                    @if($overview[$b]->count() > 4)
                    <div style="font-size:.7rem;color:var(--gray-400);margin-top:2px;">+{{ $overview[$b]->count() - 4 }} lainnya</div>
                    @endif
                @else
                <div style="font-size:.75rem;color:var(--gray-400);font-style:italic;">-</div>
                @endif
            </div>
        </div>
        @endfor
    </div>
</div>
@endsection
