@extends('layouts.app')
@section('title', 'Edit Artikel')
@section('content')
<div class="page-container" style="max-width:800px;">
    <div class="page-header"><h1 class="page-title">✏️ Edit Artikel</h1></div>
    <div class="card">
        <div class="card-body">
            @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
            <form action="{{ route('artikel.update', $artikel->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="form-group">
                    <label class="form-label">Judul Artikel *</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul', $artikel->judul) }}" required>
                </div>
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <select name="kategori" class="form-select" required>
                            @foreach(['panduan','berita','tips','teknologi','cuaca'] as $kat)
                            <option value="{{ $kat }}" {{ old('kategori',$artikel->kategori)==$kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="published" class="form-select">
                            <option value="0" {{ !$artikel->published ? 'selected' : '' }}>Draft</option>
                            <option value="1" {{ $artikel->published ? 'selected' : '' }}>Publikasikan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Ringkasan</label>
                    <input type="text" name="ringkasan" class="form-control" value="{{ old('ringkasan', $artikel->ringkasan) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Isi Artikel *</label>
                    <textarea name="konten" class="form-control" rows="14" required>{{ old('konten', $artikel->konten) }}</textarea>
                </div>
                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                    <a href="{{ route('artikel.show', $artikel->slug) }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
