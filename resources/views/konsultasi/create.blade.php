@extends('layouts.app')
@section('title', 'Buat Konsultasi')
@section('content')
<div class="page-container" style="max-width:760px;">
    <div class="page-header"><h1 class="page-title">💬 Buat Konsultasi Baru</h1></div>
    <div class="card">
        <div class="card-body">
            @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
            <form action="{{ route('konsultasi.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Judul Pertanyaan *</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Contoh: Daun padi menguning sejak 2 minggu lalu..." required>
                </div>
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label">Tanaman yang Dikonsultasikan</label>
                        <input type="text" name="tanaman" class="form-control" value="{{ old('tanaman') }}" placeholder="Padi, Jagung, Cabai...">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Prioritas</label>
                        <select name="prioritas" class="form-select">
                            <option value="rendah">🟢 Rendah</option>
                            <option value="sedang" selected>🟡 Sedang</option>
                            <option value="tinggi">🔴 Mendesak</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Detail Pertanyaan * <span style="font-size:.75rem;color:var(--gray-400);">(min. 20 karakter)</span></label>
                    <textarea name="pertanyaan" class="form-control" rows="7" placeholder="Jelaskan kondisi tanaman Anda secara detail: gejala, sudah berapa lama, kondisi lahan, dll..." required>{{ old('pertanyaan') }}</textarea>
                </div>
                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn btn-primary">Kirim Konsultasi</button>
                    <a href="{{ route('konsultasi.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
