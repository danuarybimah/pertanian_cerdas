@extends('layouts.app')
@section('title', 'Tambah Kalender Tanam')
@section('content')

<style>
    .create-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeIn 0.4s ease-out;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.875rem;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-label span {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        font-size: 0.95rem;
        color: #1f2937;
        background-color: #f9fafb;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--green-600);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(45, 122, 79, 0.12);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-control.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    .field-error {
        display: block;
        font-size: 0.8rem;
        color: #ef4444;
        margin-top: 6px;
        font-weight: 500;
    }

    .form-select {
        width: 100%;
        padding: 12px 16px;
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        font-size: 0.95rem;
        background-color: #f9fafb;
        cursor: pointer;
        transition: all 0.25s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234b5563' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        background-size: 16px;
        padding-right: 40px;
        font-family: inherit;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--green-600);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(45, 122, 79, 0.12);
    }

    .form-select.is-invalid {
        border-color: #ef4444;
        background-color: #fef2f2;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .action-row {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #f3f4f6;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--green-600), var(--green-700));
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-family: inherit;
        font-size: 0.925rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(45, 122, 79, 0.25);
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .btn-submit:hover {
        box-shadow: 0 6px 16px rgba(45, 122, 79, 0.35);
        transform: translateY(-1px);
    }

    .btn-submit:disabled {
        background: #9ca3af;
        box-shadow: none;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel {
        background-color: #f3f4f6;
        color: #4b5563;
        padding: 12px 24px;
        border-radius: 12px;
        border: none;
        font-family: inherit;
        font-size: 0.925rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="page-container" style="max-width: 800px; margin: 0 auto; padding: 24px 16px;">
    <!-- Page Header -->
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 28px;">
        <a href="{{ route('kalender-tanam.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; background-color: #ffffff; border: 1px solid #e5e7eb; color: #4b5563; transition: all 0.2s;" title="Kembali ke kalender tanam">
            <i data-lucide="arrow-left" style="width: 20px; height: 20px;"></i>
        </a>
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Tambah Kalender Tanam</h1>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 2px 0 0;">Catat acuan jadwal budidaya dan pola tanam untuk petani</p>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('error'))
    <div style="margin-bottom: 24px;">
        <div class="alert alert-error" style="padding: 14px 18px; border-radius: 12px; background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; display: flex; gap: 10px; font-size: 0.9rem; align-items: center;">
            <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0; color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="create-card">
        <div style="padding: 32px;">
            <form action="{{ route('kalender-tanam.store') }}" method="POST" id="calendarForm">
                @csrf

                <div class="grid grid-2">
                    <!-- Komoditas -->
                    <div class="form-group">
                        <label class="form-label" for="komoditas_id">Komoditas <span>*</span></label>
                        <select name="komoditas_id" id="komoditas_id" class="form-select @error('komoditas_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Komoditas --</option>
                            @foreach($komoditas as $k)
                            <option value="{{ $k->id }}" {{ old('komoditas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        @error('komoditas_id')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Bulan Tanam -->
                    <div class="form-group">
                        <label class="form-label" for="bulan_tanam">Bulan Tanam <span>*</span></label>
                        <select name="bulan_tanam" id="bulan_tanam" class="form-select @error('bulan_tanam') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Bulan --</option>
                            @php
                            $bulanList = [
                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                            ];
                            @endphp
                            @foreach($bulanList as $val => $name)
                            <option value="{{ $val }}" {{ old('bulan_tanam') == $val ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('bulan_tanam')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-2">
                    <!-- Durasi Tanam -->
                    <div class="form-group">
                        <label class="form-label" for="durasi_tanam">Durasi Tanam (Hari) <span>*</span></label>
                        <input
                            type="number"
                            name="durasi_tanam"
                            id="durasi_tanam"
                            class="form-control @error('durasi_tanam') is-invalid @enderror"
                            value="{{ old('durasi_tanam') }}"
                            placeholder="Contoh: 90"
                            min="1"
                            required
                        >
                        @error('durasi_tanam')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Musim -->
                    <div class="form-group">
                        <label class="form-label" for="musim">Musim <span>*</span></label>
                        <select name="musim" id="musim" class="form-select @error('musim') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Musim --</option>
                            <option value="kemarau" {{ old('musim') == 'kemarau' ? 'selected' : '' }}>Kemarau</option>
                            <option value="hujan" {{ old('musim') == 'hujan' ? 'selected' : '' }}>Hujan</option>
                            <option value="semua" {{ old('musim') == 'semua' ? 'selected' : '' }}>Semua / Pancaroba</option>
                        </select>
                        @error('musim')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-3">
                    <!-- Wilayah -->
                    <div class="form-group">
                        <label class="form-label" for="wilayah">Wilayah Wilayah <span>*</span></label>
                        <input
                            type="text"
                            name="wilayah"
                            id="wilayah"
                            class="form-control @error('wilayah') is-invalid @enderror"
                            value="{{ old('wilayah', 'Jawa Tengah') }}"
                            placeholder="Contoh: Semarang"
                            required
                        >
                        @error('wilayah')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Varietas -->
                    <div class="form-group">
                        <label class="form-label" for="varietas">Varietas Unggul</label>
                        <input
                            type="text"
                            name="varietas"
                            id="varietas"
                            class="form-control @error('varietas') is-invalid @enderror"
                            value="{{ old('varietas') }}"
                            placeholder="Contoh: Ciherang, IR64"
                        >
                        @error('varietas')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Produktivitas Rata-rata -->
                    <div class="form-group">
                        <label class="form-label" for="produktivitas_rata">Produktivitas (Ton/Ha)</label>
                        <input
                            type="number"
                            step="0.01"
                            name="produktivitas_rata"
                            id="produktivitas_rata"
                            class="form-control @error('produktivitas_rata') is-invalid @enderror"
                            value="{{ old('produktivitas_rata') }}"
                            placeholder="Contoh: 6.2"
                            min="0"
                        >
                        @error('produktivitas_rata')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group">
                    <label class="form-label" for="keterangan">Keterangan / Rekomendasi Tambahan</label>
                    <textarea
                        name="keterangan"
                        id="keterangan"
                        class="form-control @error('keterangan') is-invalid @enderror"
                        placeholder="Masukkan catatan pendukung waktu tanam, pemupukan, hama, atau pasokan air..."
                    >{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="action-row">
                    <a href="{{ route('kalender-tanam.index') }}" class="btn-cancel">
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                        <span>Simpan Kalender</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('calendarForm');
        const submitBtn = document.getElementById('submitBtn');

        if (form && submitBtn) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <i data-lucide="loader-2" class="animate-spin" style="width: 18px; height: 18px;"></i>
                    <span>Menyimpan Kalender...</span>
                `;
                lucide.createIcons();
            });
        }
        lucide.createIcons();
    });
</script>
@endpush
