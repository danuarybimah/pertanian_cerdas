@extends('layouts.app')
@section('title', $konsultasi->judul)
@section('content')
<div class="page-container" style="max-width:860px;">
    <div class="mb-4"><a href="{{ route('konsultasi.index') }}" style="color:var(--green-600);text-decoration:none;font-size:.875rem;">← Kembali ke Forum</a></div>

    {{-- PERTANYAAN --}}
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex-between mb-3">
                <span class="badge badge-{{ $konsultasi->status_color }}">{{ $konsultasi->status_label }}</span>
                <span style="font-size:.8rem;color:var(--gray-400);">👁️ {{ $konsultasi->views }} · 🕐 {{ $konsultasi->created_at->diffForHumans() }}</span>
            </div>
            <h1 style="font-size:1.4rem;font-weight:800;color:var(--green-900);margin-bottom:12px;">{{ $konsultasi->judul }}</h1>
            <div style="display:flex;gap:12px;align-items:center;margin-bottom:16px;padding-bottom:16px;border-bottom:1px solid var(--gray-100);">
                <div style="width:40px;height:40px;background:var(--green-100);border-radius:50%;display:grid;place-items:center;font-size:1.2rem;">👨‍🌾</div>
                <div>
                    <div style="font-weight:600;font-size:.9rem;">{{ $konsultasi->petani?->name }}</div>
                    <div style="font-size:.75rem;color:var(--gray-400);">Petani · {{ $konsultasi->petani?->wilayah }}</div>
                </div>
                @if($konsultasi->tanaman)
                <span class="badge badge-success" style="margin-left:auto;">🌿 {{ $konsultasi->tanaman }}</span>
                @endif
            </div>
            <p style="font-size:1rem;line-height:1.8;color:var(--gray-700);">{{ $konsultasi->pertanyaan }}</p>

            @auth @if(auth()->user()->id === $konsultasi->petani_id && $konsultasi->status !== 'closed')
            <div class="mt-4">
                <form action="{{ route('konsultasi.tutup', $konsultasi->id) }}" method="POST" onsubmit="return confirm('Tutup konsultasi ini?')">
                    @csrf <button type="submit" class="btn btn-outline btn-sm">🔒 Tutup Konsultasi</button>
                </form>
            </div>
            @endif @endauth
        </div>
    </div>

    {{-- JAWABAN --}}
    <h2 style="font-size:1.1rem;font-weight:700;margin-bottom:16px;color:var(--green-800);">💬 {{ $konsultasi->jawaban->count() }} Jawaban</h2>

    @forelse($konsultasi->jawaban as $j)
    <div class="card mb-4" style="{{ $j->is_best_answer ? 'border:2px solid var(--green-500);' : '' }}">
        <div class="card-body">
            @if($j->is_best_answer)
            <div style="background:var(--green-50);color:var(--green-700);font-size:.75rem;font-weight:700;padding:6px 12px;border-radius:6px;margin-bottom:12px;display:inline-block;">⭐ Jawaban Terbaik</div>
            @endif
            <div style="display:flex;gap:12px;align-items:center;margin-bottom:12px;">
                <div style="width:36px;height:36px;background:var(--gold-100);border-radius:50%;display:grid;place-items:center;font-size:1rem;">👨‍🏫</div>
                <div>
                    <div style="font-weight:600;font-size:.9rem;">{{ $j->penjawab?->name }}</div>
                    <div style="font-size:.75rem;color:var(--gray-400);">{{ $j->penjawab?->role_label }} · {{ $j->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <p style="font-size:.95rem;line-height:1.8;color:var(--gray-700);">{{ $j->jawaban }}</p>
        </div>
    </div>
    @empty
    <div class="card mb-4"><div class="card-body empty-state"><div class="empty-state-icon">🤔</div><div>Belum ada jawaban. Tunggu penyuluh menjawab.</div></div></div>
    @endforelse

    {{-- FORM JAWABAN --}}
    @auth @if((auth()->user()->isPenyuluh() || auth()->user()->isDinas()) && $konsultasi->status !== 'closed')
    <div class="card">
        <div class="card-header"><span class="card-title">✍️ Berikan Jawaban</span></div>
        <div class="card-body">
            @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
            <form action="{{ route('konsultasi.jawab', $konsultasi->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="jawaban" class="form-control" rows="5" placeholder="Tulis jawaban Anda yang informatif dan jelas..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
            </form>
        </div>
    </div>
    @elseif(auth()->user()->isPetani() && $konsultasi->status === 'closed')
    <div class="alert alert-info">🔒 Konsultasi ini telah ditutup.</div>
    @endif @endauth
</div>
@endsection
