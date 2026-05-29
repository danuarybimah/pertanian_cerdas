@extends('layouts.app')
@section('title', 'Input Harga Pasar')
@section('content')

<style>
    /* Bulk Input Layout */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    @media (max-width: 1024px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 28px;
    }

    /* Spreadsheet Table Design */
    .input-table-container {
        overflow-x: auto;
        margin-bottom: 20px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .input-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        min-width: 800px;
    }

    .input-table th {
        background-color: #f9fafb;
        color: #374151;
        padding: 14px 16px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e5e7eb;
    }

    .input-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .input-table tbody tr:hover td {
        background-color: #fbfdfc;
    }

    /* Responsive inputs in table */
    .table-control {
        width: 100%;
        padding: 10px 12px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-size: 0.875rem;
        font-family: inherit;
        background-color: #ffffff;
        transition: all 0.2s;
    }

    .table-control:focus {
        outline: none;
        border-color: var(--green-500);
        box-shadow: 0 0 0 3px rgba(45, 122, 79, 0.1);
    }

    .table-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234b5563' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
        padding-right: 32px;
    }

    .unit-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        background-color: #eaf6ee;
        color: var(--green-700);
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        border: 1px solid #c2e7cf;
        text-align: center;
        min-width: 50px;
    }

    /* Action Buttons */
    .btn-add-row {
        background-color: #ffffff;
        color: var(--green-600);
        border: 2px dashed var(--green-400);
        border-radius: 12px;
        padding: 12px;
        width: 100%;
        font-weight: 600;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 24px;
    }

    .btn-add-row:hover {
        background-color: #f0faf4;
        border-color: var(--green-600);
        color: var(--green-700);
    }

    .btn-delete-row {
        background-color: #fef2f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
        border-radius: 8px;
        padding: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-delete-row:hover {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    /* Right Sidebar styling */
    .sidebar-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        padding: 24px;
        margin-bottom: 24px;
    }

    .sidebar-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 12px;
    }

    /* Stat Items List */
    .stat-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 12px;
        border-radius: 10px;
        background-color: #f9fafb;
        border: 1px solid #f3f4f6;
    }

    .stat-name-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
    }

    .stat-val-wrapper {
        text-align: right;
    }

    .stat-price {
        font-weight: 700;
        font-size: 0.875rem;
        color: #111827;
    }

    .stat-badge {
        font-size: 0.72rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 2px;
        padding: 2px 6px;
        border-radius: 6px;
        margin-top: 2px;
    }

    .stat-badge.up {
        background-color: #d1fae5;
        color: #065f46;
    }

    .stat-badge.down {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .stat-badge.stable {
        background-color: #e5e7eb;
        color: #374151;
    }

    /* History table filter row */
    .filter-row {
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 8px;
        margin-bottom: 16px;
    }

    /* Animation & Loading */
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

    .animate-spin {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="page-container" style="max-width: 1280px; margin: 0 auto; padding: 24px 16px;">
    <!-- Page Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 1.65rem; font-weight: 800; color: #111827; margin: 0; letter-spacing: -0.5px; display: flex; align-items: center; gap: 8px;">
                💰 Input Harga Pasar Komoditas
            </h1>
            <p style="font-size: 0.875rem; color: #6b7280; margin: 4px 0 0;">Catat harga komoditas pangan dari berbagai pasar sekaligus</p>
        </div>
        <a href="{{ route('harga-pasar.index') }}" class="btn btn-outline" style="border-radius: 12px;">
            <i data-lucide="eye" style="width: 18px; height: 18px;"></i> Lihat Harga Pasar Terkini
        </a>
    </div>

    <!-- Alert notifikasi -->
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

    <div class="dashboard-grid">
        <!-- Left: Spreadsheet Input Form -->
        <div>
            <div class="form-card">
                <form action="{{ route('harga-pasar.store') }}" method="POST" id="priceBulkForm">
                    @csrf

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                        <h3 style="font-size: 1rem; font-weight: 700; color: #374151;">Daftar Input Harga</h3>
                        <span style="font-size: 0.8rem; color: #6b7280; font-weight: 500;" id="rowCountLabel">Total: 1 Baris</span>
                    </div>

                    <div class="input-table-container">
                        <table class="input-table">
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Komoditas <span style="color: #ef4444;">*</span></th>
                                    <th style="width: 12%;">Satuan</th>
                                    <th style="width: 20%;">Harga per kg (Rp) <span style="color: #ef4444;">*</span></th>
                                    <th style="width: 22%;">Lokasi Pasar <span style="color: #ef4444;">*</span></th>
                                    <th style="width: 16%;">Tanggal <span style="color: #ef4444;">*</span></th>
                                    <th style="width: 5%;"></th>
                                </tr>
                            </thead>
                            <tbody id="price-rows">
                                <!-- Row 1 (Default) -->
                                <tr>
                                    <td>
                                        <select name="items[0][komoditas_id]" class="table-control table-select select-komoditas" required>
                                            <option value="" disabled selected>Pilih...</option>
                                            @foreach($komoditas as $k)
                                            <option value="{{ $k->id }}" data-satuan="{{ $k->satuan }}">{{ $k->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <span class="unit-badge label-satuan">—</span>
                                    </td>
                                    <td>
                                        <input type="text" class="table-control input-mask-rupiah" placeholder="Input harga..." required>
                                        <input type="hidden" name="items[0][harga]" class="input-harga-real" required>
                                    </td>
                                    <td>
                                        <input type="text" name="items[0][lokasi_pasar]" class="table-control input-lokasi" placeholder="Pasar Johar..." required>
                                    </td>
                                    <td>
                                        <input type="date" name="items[0][tanggal]" class="table-control input-tanggal" value="{{ date('Y-m-d') }}" required>
                                    </td>
                                    <td style="text-align: center;">
                                        <!-- Default row cannot be deleted unless there are more rows -->
                                        <button type="button" class="btn-delete-row" style="opacity: 0.4; cursor: not-allowed;" disabled>
                                            <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Add Row Button -->
                    <button type="button" class="btn-add-row" id="btnAddRow">
                        <i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i>
                        <span>Tambah Baris Komoditas</span>
                    </button>

                    <!-- Submit Section -->
                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f3f4f6; padding-top: 20px;">
                        <span style="font-size: 0.8rem; color: #9ca3af; font-weight: 500;">* Wajib Diisi</span>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i data-lucide="save" style="width: 18px; height: 18px;"></i>
                            <span>Simpan Semua Data</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Statistics & Filters/History -->
        <div>
            <!-- Stat Card -->
            <div class="sidebar-card">
                <h4 class="sidebar-title">
                    <i data-lucide="trending-up" style="width: 18px; height: 18px; color: var(--green-600)"></i>
                    Tren Harga Terakhir
                </h4>

                @if(count($statistik) > 0)
                <div class="stat-list">
                    @foreach($statistik as $s)
                    <div class="stat-item">
                        <div>
                            <span class="stat-name-label">{{ $s['nama'] }}</span>
                            <div style="font-size: 0.72rem; color: #9ca3af;">{{ $s['pasar'] }}</div>
                        </div>
                        <div class="stat-val-wrapper">
                            <div class="stat-price">Rp {{ number_format($s['harga'], 0, ',', '.') }}</div>
                            @if($s['diff'] > 0)
                                <span class="stat-badge up">▲ Rp {{ number_format($s['diff'], 0, ',', '.') }} ({{ $s['pct'] }}%)</span>
                            @elseif($s['diff'] < 0)
                                <span class="stat-badge down">▼ Rp {{ number_format(abs($s['diff']), 0, ',', '.') }} ({{ abs($s['pct']) }}%)</span>
                            @else
                                <span class="stat-badge stable">Stabel</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="empty-state" style="padding: 12px 0;">
                    <div class="empty-state-icon" style="font-size: 1.5rem;">📊</div>
                    <div class="empty-state-text" style="font-size: 0.8rem;">Belum ada statistik komoditas</div>
                </div>
                @endif
            </div>

            <!-- History Sidebar with Filters -->
            <div class="sidebar-card">
                <h4 class="sidebar-title">
                    <i data-lucide="history" style="width: 18px; height: 18px; color: var(--green-600)"></i>
                    Riwayat Input Terbaru
                </h4>

                <!-- Filter form -->
                <form method="GET" class="filter-row">
                    <input type="date" name="filter_tanggal" class="table-control" value="{{ $filterTanggal }}" style="padding: 6px 10px; font-size: 0.8rem;" title="Filter Tanggal">
                    <input type="text" name="filter_pasar" class="table-control" placeholder="Cari pasar..." value="{{ $filterPasar }}" style="padding: 6px 10px; font-size: 0.8rem;" title="Filter Pasar">
                    <button type="submit" class="btn" style="background-color: var(--green-600); color: white; padding: 6px 10px; border-radius: 8px;">
                        <i data-lucide="search" style="width: 14px; height: 14px;"></i>
                    </button>
                </form>

                <div style="overflow-y: auto; max-height: 250px;">
                    @if($riwayatTerkini->count() > 0)
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.8rem; text-align: left;">
                        <thead>
                            <tr style="border-bottom: 1px solid #e5e7eb; color: #6b7280; font-weight: 700;">
                                <th style="padding: 6px 4px;">Komoditas</th>
                                <th style="padding: 6px 4px;">Harga</th>
                                <th style="padding: 6px 4px;">Pasar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayatTerkini as $r)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 8px 4px; font-weight: 600; color: #374151;">{{ $r->komoditas?->nama }}</td>
                                <td style="padding: 8px 4px; color: var(--green-700); font-weight: 700;">Rp {{ number_format($r->harga, 0, ',', '.') }}</td>
                                <td style="padding: 8px 4px; color: #9ca3af; font-size: 0.75rem;">{{ $r->lokasi_pasar }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state" style="padding: 24px 0;">
                        <div class="empty-state-icon" style="font-size: 1.8rem;">📋</div>
                        <div class="empty-state-text" style="font-size: 0.85rem;">Tidak ada riwayat input cocok</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const priceRows = document.getElementById('price-rows');
        const btnAddRow = document.getElementById('btnAddRow');
        const form = document.getElementById('priceBulkForm');
        const submitBtn = document.getElementById('submitBtn');
        const rowCountLabel = document.getElementById('rowCountLabel');

        let rowIndex = 1;

        // Map satuan komoditas dari blade ke JS
        const unitsMap = {
            @foreach($komoditas as $k)
                '{{ $k->id }}': '{{ $k->satuan }}',
            @endforeach
        };

        // Fungsi memperbarui total baris label
        function updateRowCount() {
            const rows = priceRows.querySelectorAll('tr');
            rowCountLabel.textContent = `Total: ${rows.length} Baris`;

            // Toggle disable/enable delete button row pertama
            const firstRowDeleteBtn = priceRows.querySelector('tr .btn-delete-row');
            if (rows.length === 1) {
                firstRowDeleteBtn.disabled = true;
                firstRowDeleteBtn.style.opacity = '0.4';
                firstRowDeleteBtn.style.cursor = 'not-allowed';
            } else {
                firstRowDeleteBtn.disabled = false;
                firstRowDeleteBtn.style.opacity = '1';
                firstRowDeleteBtn.style.cursor = 'pointer';
            }
        }

        // Fungsi memformat input teks menjadi format rupiah live
        function formatRupiahInput(value) {
            let numberString = value.replace(/[^,\d]/g, '').toString();
            let split = numberString.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        // Fungsi mendaftarkan event listener pada baris tertentu
        function registerRowEvents(row) {
            const selectKomoditas = row.querySelector('.select-komoditas');
            const labelSatuan = row.querySelector('.label-satuan');
            const inputMask = row.querySelector('.input-mask-rupiah');
            const inputReal = row.querySelector('.input-harga-real');
            const btnDelete = row.querySelector('.btn-delete-row');

            // 1. Event Dropdown Komoditas untuk memuat Satuan
            selectKomoditas.addEventListener('change', function() {
                const selectedVal = this.value;
                if (unitsMap[selectedVal]) {
                    labelSatuan.textContent = unitsMap[selectedVal];
                } else {
                    labelSatuan.textContent = '—';
                }
            });

            // 2. Event Input Masking Rupiah Live
            inputMask.addEventListener('input', function() {
                const cleanedValue = this.value.replace(/[^0-9]/g, '');
                inputReal.value = cleanedValue; // simpan angka murni ke input hidden

                if (cleanedValue) {
                    this.value = 'Rp ' + formatRupiahInput(cleanedValue);
                } else {
                    this.value = '';
                }
            });

            // 3. Event Hapus Baris
            btnDelete.addEventListener('click', function(e) {
                e.preventDefault();
                row.remove();
                updateRowCount();
            });
        }

        // Inisialisasi baris pertama bawaan
        registerRowEvents(priceRows.querySelector('tr'));
        updateRowCount();

        // Aksi Tombol "+ Tambah Baris Komoditas"
        btnAddRow.addEventListener('click', function(e) {
            e.preventDefault();

            // Salin nilai tanggal dan lokasi pasar dari baris terakhir untuk kemudahan entri data
            const allRows = priceRows.querySelectorAll('tr');
            const lastRow = allRows[allRows.length - 1];
            const lastLokasi = lastRow.querySelector('.input-lokasi').value;
            const lastTanggal = lastRow.querySelector('.input-tanggal').value;

            // Buat elemen baris baru
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>
                    <select name="items[${rowIndex}][komoditas_id]" class="table-control table-select select-komoditas" required>
                        <option value="" disabled selected>Pilih...</option>
                        @foreach($komoditas as $k)
                        <option value="{{ $k->id }}" data-satuan="{{ $k->satuan }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <span class="unit-badge label-satuan">—</span>
                </td>
                <td>
                    <input type="text" class="table-control input-mask-rupiah" placeholder="Input harga..." required>
                    <input type="hidden" name="items[${rowIndex}][harga]" class="input-harga-real" required>
                </td>
                <td>
                    <input type="text" name="items[${rowIndex}][lokasi_pasar]" class="table-control input-lokasi" placeholder="Pasar Johar..." value="${lastLokasi}" required>
                </td>
                <td>
                    <input type="date" name="items[${rowIndex}][tanggal]" class="table-control input-tanggal" value="${lastTanggal}" required>
                </td>
                <td style="text-align: center;">
                    <button type="button" class="btn-delete-row">
                        <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                    </button>
                </td>
            `;

            priceRows.appendChild(tr);
            registerRowEvents(tr);
            rowIndex++;

            // Re-inisialisasi Lucide icons di baris baru
            lucide.createIcons();
            updateRowCount();
        });

        // Submit form loading spinner
        form.addEventListener('submit', function(e) {
            // Cek apakah ada komoditas kosong
            const selects = priceRows.querySelectorAll('.select-komoditas');
            let selectsValid = true;
            selects.forEach(sel => {
                if (!sel.value) selectsValid = false;
            });

            if (!selectsValid) {
                e.preventDefault();
                alert('Tolong pilih komoditas di setiap baris!');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <i data-lucide="loader-2" class="animate-spin" style="width: 18px; height: 18px;"></i>
                <span>Menyimpan Data Harga...</span>
            `;
            lucide.createIcons();
        });

        // Inisialisasi Lucide
        lucide.createIcons();
    });
</script>
@endpush
