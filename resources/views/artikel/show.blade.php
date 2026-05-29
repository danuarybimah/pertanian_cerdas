@extends('layouts.app')
@section('title', $artikel->judul)
@section('content')
    <div class="page-container" style="max-width:860px;">
        <div class="mb-4">
            <a href="{{ route('artikel.index') }}" style="color:var(--green-600);text-decoration:none;font-size:.875rem;">←
                Kembali ke Artikel</a>
        </div>

        <div class="card mb-6">
            <div
                style="height:240px; background:linear-gradient(135deg,var(--green-800),var(--green-500)); display:grid; place-items:center; overflow:hidden;">
                @if ($artikel->gambar)
                    <img src="{{ asset($artikel->gambar) }}" alt="{{ $artikel->judul }}"
                        style="width:100%; height:100%; object-fit:cover;">
                @else
                    <span
                        style="font-size:5rem;">{{ ['panduan' => '📖', 'berita' => '📢', 'tips' => '💡', 'teknologi' => '🔬', 'cuaca' => '🌤️'][$artikel->kategori] ?? '📄' }}</span>
                @endif
            </div>
            <div class="card-body">
                <div style="display:flex;gap:10px;align-items:center;margin-bottom:12px;">
                    <span class="badge badge-success">{{ $artikel->kategori_label }}</span>
                    <span style="font-size:.8rem;color:var(--gray-400);">👤 {{ $artikel->penulis?->name }} ·
                        {{ $artikel->penulis?->role_label }}</span>
                    <span style="font-size:.8rem;color:var(--gray-400);">🕐
                        {{ $artikel->published_at?->format('d F Y') }}</span>
                    <span style="font-size:.8rem;color:var(--gray-400);">👁️ {{ $artikel->views }} views</span>
                </div>
                <h1 style="font-size:1.8rem;font-weight:800;color:var(--green-900);line-height:1.3;margin-bottom:20px;">
                    {{ $artikel->judul }}</h1>
                <hr class="divider">
                <div class="artikel-isi-konten" style="font-size:1rem;line-height:1.8;color:var(--gray-800);">
                    {!! $artikel->konten !!}
                </div>

                @auth
                    @if (auth()->user()->id === $artikel->user_id || auth()->user()->isDinas())
                        <hr class="divider">
                        <div style="display:flex;gap:10px;">
                            <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                            <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST"
                                onsubmit="return confirm('Hapus artikel ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">🗑️ Hapus</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        @if ($lainnya->count())
            <h2 class="section-title">Artikel Terkait</h2>
            <div class="grid grid-3">
                @foreach ($lainnya as $art)
                    <a href="{{ route('artikel.show', $art->slug) }}" style="text-decoration:none;">
                        <div class="artikel-card">
                            <div class="artikel-card-img" style="height:120px;font-size:2rem;">
                                {{ ['panduan' => '📖', 'berita' => '📢', 'tips' => '💡', 'teknologi' => '🔬', 'cuaca' => '🌤️'][$art->kategori] ?? '📄' }}
                            </div>
                            <div class="artikel-card-body">
                                <div class="artikel-card-kategori">{{ $art->kategori_label }}</div>
                                <div class="artikel-card-title">{{ Str::limit($art->judul, 50) }}</div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
