@extends('layouts.app')
@section('title', 'Artikel')
@section('content')
    <div class="page-container">
        <div class="page-header flex-between">
            <div>
                <h1 class="page-title">📰 Artikel & Panduan</h1>
                <p class="page-subtitle">Informasi pertanian terkini dari penyuluh ahli</p>
            </div>
            @auth
                @if (auth()->user()->role == 'dinas' || auth()->user()->role == 'penyuluh')
                    <a href="{{ route('artikel.create') }}" class="btn btn-primary">Tulis Artikel</a>
                @endif
            @endauth
        </div>

        {{-- FILTER KATEGORI --}}
        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;">
            <a href="{{ route('artikel.index') }}"
                class="btn {{ !$kategori ? 'btn-primary' : 'btn-outline' }} btn-sm">Semua</a>
            @foreach (['panduan', 'berita', 'tips', 'teknologi', 'cuaca'] as $kat)
                <a href="{{ route('artikel.index', ['kategori' => $kat]) }}"
                    class="btn {{ $kategori == $kat ? 'btn-primary' : 'btn-outline' }} btn-sm">{{ ucfirst($kat) }}</a>
            @endforeach
        </div>

        @if ($artikel->count())
            <div class="grid grid-3 mb-6">
                @foreach ($artikel as $art)
                    <a href="{{ route('artikel.show', $art->slug) }}" style="text-decoration:none;">
                        <div class="artikel-card">

                            <div class="artikel-card-img"
                                style="display:grid; place-items:center; overflow:hidden; background:linear-gradient(135deg,{{ ['#1a4a2e', '#2d7a4f', '#a07810', '#5b21b6', '#1e40af'][array_search($art->kategori, ['panduan', 'tips', 'berita', 'teknologi', 'cuaca']) % 5] }},{{ ['#3a9a64', '#52b67a', '#d4a017', '#7c3aed', '#3b82f6'][array_search($art->kategori, ['panduan', 'tips', 'berita', 'teknologi', 'cuaca']) % 5] }});">
                                @if ($art->gambar)
                                    <img src="{{ asset($art->gambar) }}" alt="{{ $art->judul }}"
                                        style="width:100%; height:100%; object-fit:cover;">
                                @else
                                    <span
                                        style="font-size:2rem;">{{ ['panduan' => '📖', 'berita' => '📢', 'tips' => '💡', 'teknologi' => '🔬', 'cuaca' => '🌤️'][$art->kategori] ?? '📄' }}</span>
                                @endif
                            </div>

                            <div class="artikel-card-body">
                                <div class="artikel-card-kategori">{{ $art->kategori_label }}</div>
                                <div class="artikel-card-title">{{ $art->judul }}</div>
                                <p style="font-size:.8rem;color:var(--gray-600);margin-bottom:10px;">
                                    {{ Str::limit($art->ringkasan, 90) }}</p>
                                <div class="artikel-card-meta">👤 {{ $art->penulis?->name }} · 👁️ {{ $art->views }} ·
                                    🕐 {{ $art->published_at?->diffForHumans() }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div>{{ $artikel->links() }}</div>
        @else
            <div class="empty-state card card-body">
                <div class="empty-state-icon">📰</div>
                <div class="empty-state-text">Belum ada artikel di kategori ini</div>
            </div>
        @endif
    </div>
@endsection
