@extends('layouts.app')
@section('title', 'Tulis Artikel')
@section('content')
<div class="page-container" style="max-width:800px;">
    <div class="page-header"><h1 class="page-title">✏️ Tulis Artikel</h1></div>
    <div class="card">
        <div class="card-body">
            @if($errors->any())<div class="alert alert-error">{{ $errors->first() }}</div>@endif
            <form action="{{ route('artikel.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Judul Artikel *</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" placeholder="Cara Meningkatkan Produksi Padi..." required>
                </div>
                <div class="grid grid-2">
                    <div class="form-group">
                        <label class="form-label">Kategori *</label>
                        <select name="kategori" class="form-select" required>
                            <option value="panduan" {{ old('kategori')=='panduan'?'selected':'' }}>Panduan</option>
                            <option value="berita"  {{ old('kategori')=='berita'?'selected':'' }}>Berita</option>
                            <option value="tips"    {{ old('kategori')=='tips'?'selected':'' }}>Tips & Trik</option>
                            <option value="teknologi" {{ old('kategori')=='teknologi'?'selected':'' }}>Teknologi</option>
                            <option value="cuaca"   {{ old('kategori')=='cuaca'?'selected':'' }}>Info Cuaca</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="published" class="form-select">
                            <option value="0">Draft (Simpan dulu)</option>
                            <option value="1">Publikasikan sekarang</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Ringkasan (opsional)</label>
                    <input type="text" name="ringkasan" class="form-control" value="{{ old('ringkasan') }}" placeholder="Deskripsi singkat artikel...">
                </div>
                <div class="form-group">
                    <label class="form-label">Isi Artikel *</label>
                    <textarea name="konten" class="form-control" rows="14" placeholder="Tulis isi artikel di sini..." required>{{ old('konten') }}</textarea>
                </div>
                <div style="display:flex;gap:12px;">
                    <button type="submit" class="btn btn-primary">💾 Simpan Artikel</button>
                    <a href="{{ route('artikel.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
