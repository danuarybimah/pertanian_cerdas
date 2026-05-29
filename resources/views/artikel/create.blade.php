@extends('layouts.app')
@section('title', 'Tulis Artikel Baru')
@section('content')

<!-- Quill Rich Text Editor Styles -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<style>
    /* Premium Form Styling */
    .create-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeIn 0.4s ease-out;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.9rem;
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

    /* Drag & Drop Image Upload Zone */
    .upload-zone {
        position: relative;
        border: 2px dashed #d1d5db;
        border-radius: 16px;
        background-color: #f9fafb;
        padding: 28px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
        cursor: pointer;
        overflow: hidden;
    }

    .upload-zone:hover {
        border-color: var(--green-600);
        background-color: #f4faf6;
    }

    .upload-zone.dragover {
        border-color: var(--green-600);
        background-color: #eaf6ee;
    }

    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        cursor: pointer;
        z-index: 5;
    }

    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        pointer-events: none;
    }

    .upload-icon {
        width: 42px;
        height: 42px;
        color: #9ca3af;
        margin-bottom: 12px;
        transition: color 0.2s;
    }

    .upload-zone:hover .upload-icon {
        color: var(--green-600);
    }

    .upload-text {
        font-size: 0.9rem;
        color: #4b5563;
        font-weight: 500;
    }

    .upload-text strong {
        color: var(--green-600);
    }

    .upload-hint {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 6px;
    }

    /* Image Preview Styling */
    .preview-container {
        width: 100%;
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        z-index: 10;
    }

    .image-preview {
        width: 100%;
        max-height: 280px;
        object-fit: cover;
        display: block;
        border-radius: 12px;
    }

    .preview-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px;
        color: #ffffff;
    }

    .file-info {
        font-size: 0.8rem;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 65%;
    }

    .btn-remove-image {
        background-color: #ef4444;
        border: none;
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
        pointer-events: auto;
    }

    .btn-remove-image:hover {
        background-color: #dc2626;
    }

    /* Quill Snow Custom Theme Overrides */
    .ql-toolbar.ql-snow {
        border: 2px solid #e5e7eb !important;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        background-color: #f9fafb;
        padding: 10px 14px !important;
    }

    .ql-container.ql-snow {
        border: 2px solid #e5e7eb !important;
        border-top: none !important;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
        font-family: inherit;
        background-color: #ffffff;
    }

    .ql-editor {
        min-height: 260px;
        font-size: 0.95rem;
        color: #1f2937;
        line-height: 1.7;
    }

    .ql-editor::before {
        color: #9ca3af !important;
        font-style: normal;
    }

    .ql-editor:focus {
        background-color: #ffffff;
    }

    .editor-wrapper.is-invalid .ql-toolbar.ql-snow,
    .editor-wrapper.is-invalid .ql-container.ql-snow {
        border-color: #ef4444 !important;
    }

    /* Buttons & Form Actions */
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

    /* Animation */
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

<div class="page-container" style="max-width: 860px; margin: 0 auto; padding: 24px 16px;">
    <!-- Page Header -->
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 28px;">
        <a href="{{ route('artikel.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 12px; background-color: #ffffff; border: 1px solid #e5e7eb; color: #4b5563; transition: all 0.2s;" title="Kembali ke daftar artikel">
            <i data-lucide="arrow-left" style="width: 20px; height: 20px;"></i>
        </a>
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px;">Tulis Artikel Baru</h1>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 2px 0 0;">Publikasikan panduan, berita, atau tips pertanian modern</p>
        </div>
    </div>

    <!-- Alert Sukses / Gagal -->
    @if(session('error'))
    <div style="margin-bottom: 24px;">
        <div class="alert alert-error" style="padding: 14px 18px; border-radius: 12px; background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; display: flex; gap: 10px; font-size: 0.9rem; align-items: center;">
            <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0; color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Main Card Form -->
    <div class="create-card">
        <div style="padding: 32px;">
            <form action="{{ route('artikel.store') }}" method="POST" id="articleForm" enctype="multipart/form-data">
                @csrf

                <!-- Judul Artikel -->
                <div class="form-group">
                    <label class="form-label" for="judul">Judul Artikel <span>*</span></label>
                    <input
                        type="text"
                        name="judul"
                        id="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Cara Sukses Menanam Padi Hidroponik di Lahan Sempit"
                        required
                        autofocus
                    >
                    @error('judul')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Grid Kategori & Status -->
                <div class="grid grid-2" style="margin-bottom: 4px;">
                    <!-- Kategori -->
                    <div class="form-group">
                        <label class="form-label" for="kategori">Kategori Artikel <span>*</span></label>
                        <select name="kategori" id="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="panduan" {{ old('kategori') == 'panduan' ? 'selected' : '' }}>Panduan</option>
                            <option value="berita" {{ old('kategori') == 'berita' ? 'selected' : '' }}>Berita</option>
                            <option value="tips" {{ old('kategori') == 'tips' ? 'selected' : '' }}>Tips & Trik</option>
                            <option value="teknologi" {{ old('kategori') == 'teknologi' ? 'selected' : '' }}>Teknologi</option>
                            <option value="cuaca" {{ old('kategori') == 'cuaca' ? 'selected' : '' }}>Info Cuaca</option>
                        </select>
                        @error('kategori')
                            <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Status Published -->
                    <div class="form-group">
                        <label class="form-label" for="published">Status Publikasi</label>
                        <select name="published" id="published" class="form-select">
                            <option value="1" {{ old('published', '1') == '1' ? 'selected' : '' }}>Publikasikan Sekarang (Aktif)</option>
                            <option value="0" {{ old('published') == '0' ? 'selected' : '' }}>Simpan sebagai Draft</option>
                        </select>
                    </div>
                </div>

                <!-- Ringkasan Singkat -->
                <div class="form-group">
                    <label class="form-label" for="ringkasan">Ringkasan Artikel</label>
                    <input
                        type="text"
                        name="ringkasan"
                        id="ringkasan"
                        class="form-control @error('ringkasan') is-invalid @enderror"
                        value="{{ old('ringkasan') }}"
                        placeholder="Deskripsi singkat yang tampil di beranda (Maks. 300 karakter)"
                        maxlength="300"
                    >
                    <span style="font-size: 0.75rem; color: #9ca3af; margin-top: 4px; display: block;">Jika dikosongkan, sistem akan otomatis mengambil ringkasan dari 150 karakter pertama isi artikel.</span>
                    @error('ringkasan')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Upload Gambar -->
                <div class="form-group">
                    <label class="form-label">Gambar Utama</label>
                    <div class="upload-zone" id="uploadZone">
                        <input type="file" name="gambar" id="gambarInput" accept="image/*" class="file-input">
                        
                        <!-- Placeholder Upload -->
                        <div class="upload-placeholder" id="uploadPlaceholder">
                            <i data-lucide="image-plus" class="upload-icon"></i>
                            <span class="upload-text">Tarik & lepas gambar di sini, atau <strong>pilih file gambar</strong></span>
                            <span class="upload-hint">Format yang didukung: JPG, JPEG, PNG, WEBP, SVG (Maks. 2MB)</span>
                        </div>
                        
                        <!-- Preview Gambar -->
                        <div class="preview-container" id="previewContainer" style="display: none;">
                            <img src="" alt="Pratinjau Gambar" class="image-preview" id="imagePreview">
                            <div class="preview-overlay">
                                <span class="file-info" id="fileInfo">nama_file.jpg (128 KB)</span>
                                <button type="button" class="btn-remove-image" id="btnRemoveImage">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i> Hapus Gambar
                                </button>
                            </div>
                        </div>
                    </div>
                    @error('gambar')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Isi Artikel (Rich Text Editor) -->
                <div class="form-group">
                    <label class="form-label">Isi Artikel <span>*</span></label>
                    <div class="editor-wrapper @error('konten') is-invalid @enderror" id="editorWrapper">
                        <input type="hidden" name="konten" id="konten" value="{{ old('konten') }}" required>
                        <div id="editor-container"></div>
                    </div>
                    @error('konten')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="action-row">
                    <a href="{{ route('artikel.index') }}" class="btn-cancel">
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                        <span>Simpan Artikel</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Inisialisasi Quill Rich Text Editor
    document.addEventListener('DOMContentLoaded', function() {
        var toolbarOptions = [
            [{ 'header': [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            ['link', 'blockquote'],
            ['clean']
        ];

        var quill = new Quill('#editor-container', {
            theme: 'snow',
            placeholder: 'Tulis isi artikel lengkap Anda di sini secara menarik...',
            modules: {
                toolbar: toolbarOptions
            }
        });

        // Load data konten lama jika ada (saat validasi gagal)
        const oldContent = document.getElementById('konten').value;
        if (oldContent) {
            quill.root.innerHTML = oldContent;
        }

        // Sinkronisasi Quill Editor ke input hidden sebelum disubmit
        const form = document.getElementById('articleForm');
        const submitBtn = document.getElementById('submitBtn');
        const editorWrapper = document.getElementById('editorWrapper');

        form.addEventListener('submit', function(e) {
            const editorContent = quill.root.innerHTML;
            
            // Jika editor kosong atau hanya berisi tag paragraf kosong
            if (quill.getText().trim() === '') {
                e.preventDefault();
                editorWrapper.classList.add('is-invalid');
                alert('Isi artikel wajib diisi!');
                return;
            }
            
            document.getElementById('konten').value = editorContent;
            
            // Animasi Loading Submit
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <i data-lucide="loader-2" class="animate-spin" style="width: 18px; height: 18px;"></i>
                <span>Menyimpan Artikel...</span>
            `;
            lucide.createIcons();
        });

        // Penanganan Input File Gambar & Preview
        const gambarInput = document.getElementById('gambarInput');
        const uploadZone = document.getElementById('uploadZone');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const fileInfo = document.getElementById('fileInfo');
        const btnRemoveImage = document.getElementById('btnRemoveImage');

        function formatBytes(bytes, decimals = 2) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const dm = decimals < 0 ? 0 : decimals;
            const sizes = ['Bytes', 'KB', 'MB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }

        function showPreview(file) {
            // Validasi format file gambar
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung! Pilih berkas gambar (.jpg, .png, .webp, .svg)');
                gambarInput.value = '';
                return;
            }

            // Validasi ukuran berkas (2MB = 2 * 1024 * 1024 bytes)
            if (file.size > 2097152) {
                alert('Ukuran berkas terlalu besar! Maksimal ukuran gambar adalah 2MB.');
                gambarInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                fileInfo.textContent = `${file.name} (${formatBytes(file.size)})`;
                uploadPlaceholder.style.display = 'none';
                previewContainer.style.display = 'block';
                uploadZone.style.borderStyle = 'solid';
            }
            reader.readAsDataURL(file);
        }

        // Event listener saat file dipilih
        gambarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                showPreview(this.files[0]);
            }
        });

        // Event listener untuk drag & drop
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadZone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadZone.classList.add('dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadZone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                uploadZone.classList.remove('dragover');
            }, false);
        });

        uploadZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files[0]) {
                gambarInput.files = files;
                showPreview(files[0]);
            }
        }, false);

        // Hapus Gambar dari Pratinjau
        btnRemoveImage.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            gambarInput.value = '';
            imagePreview.src = '';
            previewContainer.style.display = 'none';
            uploadPlaceholder.style.display = 'flex';
            uploadZone.style.borderStyle = 'dashed';
        });

        // Inisialisasi Lucide
        lucide.createIcons();
    });
</script>
@endpush
