@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('content')

<style>
    .users-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        animation: fadeIn 0.4s ease-out;
    }

    /* Responsive Table Styles */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .management-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        min-width: 800px;
    }

    .management-table th {
        background-color: #f9fafb;
        color: #374151;
        padding: 16px 20px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .management-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.925rem;
        color: #4b5563;
        vertical-align: middle;
    }

    .management-table tbody tr:hover td {
        background-color: #fbfdfc;
    }

    /* Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-status.aktif {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
    }

    .badge-status.jarang-aktif {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Buttons */
    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        border: 1px solid transparent;
        text-decoration: none;
        font-family: inherit;
    }

    .btn-promote {
        background-color: #eaf6ee;
        color: var(--green-700);
        border-color: #c2e7cf;
    }

    .btn-promote:hover {
        background-color: var(--green-600);
        color: white;
        border-color: var(--green-600);
    }

    .btn-demote {
        background-color: #fffbeb;
        color: #b45309;
        border-color: #fef3c7;
    }

    .btn-demote:hover {
        background-color: #f59e0b;
        color: white;
        border-color: #f59e0b;
    }

    /* Custom Beautiful Pagination links */
    .pagination-wrapper {
        margin-top: 24px;
        padding: 20px;
        display: flex;
        justify-content: center;
        border-top: 1px solid #f3f4f6;
    }

    .pagination-wrapper nav {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .pagination-wrapper .page-link,
    .pagination-wrapper span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        color: #4b5563;
        background-color: #f9fafb;
        border: 1px solid #e5e7eb;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination-wrapper .page-link:hover {
        background-color: #eaf6ee;
        color: var(--green-700);
        border-color: var(--green-300);
    }

    .pagination-wrapper .active span {
        background-color: var(--green-600);
        color: #ffffff;
        border-color: var(--green-600);
        box-shadow: 0 4px 10px rgba(45, 122, 79, 0.2);
    }

    .pagination-wrapper .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #f3f4f6;
        color: #9ca3af;
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

<div class="page-container" style="max-width: 1200px; margin: 0 auto; padding: 24px 16px;">
    <!-- Page Header -->
    <div style="margin-bottom: 28px;">
        <h1 style="font-size: 1.6rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px; display: flex; align-items: center; gap: 8px;">
            👥 Kelola Pengguna & Penyuluh
        </h1>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 4px 0 0;">Manajemen otorisasi peran Petani dan Penyuluh Pertanian Kabupaten</p>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
    <div style="margin-bottom: 24px;">
        <div class="alert alert-success" style="padding: 14px 18px; border-radius: 12px; background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; display: flex; gap: 10px; font-size: 0.9rem; align-items: center;">
            <i data-lucide="check-circle" style="width: 20px; height: 20px; flex-shrink: 0; color: #16a34a;"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div style="margin-bottom: 24px;">
        <div class="alert alert-error" style="padding: 14px 18px; border-radius: 12px; background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; display: flex; gap: 10px; font-size: 0.9rem; align-items: center;">
            <i data-lucide="alert-circle" style="width: 20px; height: 20px; flex-shrink: 0; color: #dc2626;"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Search Bar -->
    <div style="margin-bottom: 24px; display: flex; justify-content: flex-start; align-items: center; flex-wrap: wrap; gap: 12px;">
        <form action="{{ route('dinas.users.index') }}" method="GET" style="display: flex; gap: 8px; width: 100%; max-width: 440px;">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}" 
                placeholder="Cari nama atau email..." 
                class="form-control" 
                style="padding: 10px 14px; border-radius: 12px; border: 2px solid #e5e7eb; font-size: 0.875rem; width: 100%;"
            >
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; border-radius: 12px; font-weight: 600; font-size: 0.875rem;">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('dinas.users.index') }}" class="btn btn-outline" style="padding: 10px 16px; border-radius: 12px; font-weight: 600; font-size: 0.875rem; display: flex; align-items: center; justify-content: center;">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Users Table Card -->
    <div class="users-card">
        <div class="table-responsive">
            <table class="management-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Nama Lengkap</th>
                        <th style="width: 25%;">Alamat Email</th>
                        <th style="width: 15%;">Wilayah</th>
                        <th style="width: 15%;">Status Keaktifan</th>
                        <th style="width: 20%;">Aksi Ubah Peran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td style="font-weight: 600; color: #111827;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: #f3f4f6; color: var(--green-700); font-weight: 700; font-size: 0.8rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span>{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->wilayah)
                                <span style="font-weight: 500; color: #374151;">{{ $user->wilayah }}</span>
                            @else
                                <span style="color: #9ca3af; font-style: italic;">Tidak Diisi</span>
                            @endif
                        </td>
                        <td>
                            @php
                                // Hitung keaktifan: Aktif jika ada perubahan data atau pembuatan akun dalam 7 hari terakhir
                                $isAktif = $user->updated_at && $user->updated_at->gt(now()->subDays(7));
                            @endphp
                            @if($isAktif)
                                <span class="badge-status aktif">
                                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background-color: #10b981;"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="badge-status jarang-aktif">
                                    <span style="display: inline-block; width: 6px; height: 6px; border-radius: 50%; background-color: #ef4444;"></span>
                                    Jarang Aktif
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->isPetani() || $user->isPenyuluh())
                                <form action="{{ route('dinas.users.update-role', $user->id) }}" method="POST" class="role-update-form" style="display: flex; align-items: center; gap: 8px;" onsubmit="return confirm('Apakah Anda yakin ingin mengubah peran pengguna ini?');">
                                    @csrf
                                    <select name="role" class="table-control" style="padding: 8px 12px; font-size: 0.85rem; border-radius: 8px; border: 1px solid #d1d5db; min-width: 120px; cursor: pointer; background-color: #f9fafb; font-family: inherit; transition: all 0.2s;">
                                        <option value="petani" {{ $user->role === 'petani' ? 'selected' : '' }}>Petani</option>
                                        <option value="penyuluh" {{ $user->role === 'penyuluh' ? 'selected' : '' }}>Penyuluh</option>
                                    </select>
                                    <button type="submit" class="btn-action btn-promote" style="padding: 8px 14px; border-radius: 8px; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="check" style="width: 14px; height: 14px;"></i> Simpan
                                    </button>
                                </form>
                            @else
                                <span style="font-size: 0.8rem; color: #9ca3af; font-style: italic;">Tidak dapat diubah</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px 0;">
                            <div style="font-size: 2rem; margin-bottom: 8px;">👥</div>
                            <div style="font-size: 0.95rem; color: #9ca3af; font-weight: 500;">Tidak ditemukan data Petani atau Penyuluh</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Custom Pagination Links -->
        @if($users->hasPages())
        <div class="pagination-wrapper">
            <nav role="navigation" aria-label="Pagination Navigation">
                {{-- Previous Page Link --}}
                @if ($users->onFirstPage())
                    <span aria-disabled="true">
                        <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i>
                    </span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="page-link" rel="prev">
                        <i data-lucide="chevron-left" style="width: 16px; height: 16px;"></i>
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                        <span class="active" aria-current="page"><span>{{ $page }}</span></span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="page-link" rel="next">
                        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                    </a>
                @else
                    <span aria-disabled="true">
                        <i data-lucide="chevron-right" style="width: 16px; height: 16px;"></i>
                    </span>
                @endif
            </nav>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.role-update-form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const btn = this.querySelector('button');
                btn.disabled = true;
                btn.style.opacity = '0.7';
                btn.style.cursor = 'not-allowed';
                btn.innerHTML = `
                    <i data-lucide="loader-2" class="animate-spin" style="width: 14px; height: 14px;"></i> Memproses...
                `;
                lucide.createIcons();
            });
        });

        // Initialize lucide
        if (window.lucide) {
            lucide.createIcons();
        }
    });
</script>
@endpush
