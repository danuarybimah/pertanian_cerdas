@extends('layouts.app')
@section('title', 'Konsultasi')
@section('content')
<div class="page-container">
    <div class="page-header flex-between">
        <div><h1 class="page-title">💬 Forum Konsultasi</h1><p class="page-subtitle">Tanya langsung ke penyuluh pertanian berpengalaman</p></div>
        @auth @if(auth()->user()->isPetani())
        <a href="{{ route('konsultasi.create') }}" class="btn btn-primary">+ Buat Konsultasi</a>
        @endif @endauth
    </div>

    @if(is_a($konsultasi, 'Illuminate\Pagination\LengthAwarePaginator') ? $konsultasi->count() : $konsultasi->count())
    <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($konsultasi as $k)
        <a href="{{ route('konsultasi.show', $k->id) }}" style="text-decoration:none;">
            <div class="konsultasi-item" style="display:flex;gap:16px;align-items:flex-start;">
                <div style="width:48px;height:48px;background:var(--green-100);border-radius:10px;display:grid;place-items:center;font-size:1.4rem;flex-shrink:0;">
                    {{ $k->status === 'answered' ? '✅' : ($k->status === 'open' ? '❓' : '🔄') }}
                </div>
                <div style="flex:1;">
                    <div class="flex-between mb-1">
                        <div class="konsultasi-title">{{ $k->judul }}</div>
                        <span class="badge badge-{{ $k->status_color }}">{{ $k->status_label }}</span>
                    </div>
                    <p style="font-size:.85rem;color:var(--gray-600);margin-bottom:8px;">{{ Str::limit($k->pertanyaan, 120) }}</p>
                    <div class="konsultasi-meta">
                        <span>👤 {{ $k->petani?->name }}</span>
                        @if($k->tanaman)<span>🌿 {{ $k->tanaman }}</span>@endif
                        <span>💬 {{ $k->jawaban->count() }} jawaban</span>
                        <span>👁️ {{ $k->views }}</span>
                        <span>🕐 {{ $k->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="empty-state card card-body">
        <div class="empty-state-icon">💬</div>
        <div class="empty-state-text">Belum ada konsultasi</div>
        @auth @if(auth()->user()->isPetani())
        <a href="{{ route('konsultasi.create') }}" class="btn btn-primary btn-sm mt-4">Mulai Konsultasi</a>
        @endif @endauth
    </div>
    @endif
</div>
@endsection
