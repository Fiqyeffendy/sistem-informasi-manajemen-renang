@extends('layouts.app')

@section('content')
{{-- Halaman ini memuat form input presensi dan riwayat absensi pelatih. --}}
{{-- Alerts for Session Feedback --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-octagon-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li><i class="bi bi-x-circle me-1"></i>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    {{-- Form untuk mencatat kehadiran siswa dari jadwal yang dipilih. --}}
    <div class="col-12 col-lg-4">
        <div class="card-custom border shadow-sm rounded-4 bg-white h-100 overflow-hidden fade-in">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clipboard2-check me-2 text-primary fs-5"></i>
                    <h2 class="fw-800 text-main mb-0" style="font-size: 1.1rem;">Input Presensi Kelas</h2>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('pelatih.presensi.store') }}" method="POST">
                    @csrf
                    
                    {{-- Pilih jadwal untuk menentukan siswa yang terkait. --}}
                    <div class="mb-3">
                        <label class="form-label small fw-700 text-secondary">PILIH JADWAL KELAS <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3 py-2" id="input-presensi-jadwal" name="jadwal_id" required>
                            <option value="">-- Pilih Jadwal Kelas --</option>
                            @foreach($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}" data-siswa-id="{{ $jadwal->siswa_id }}" data-siswa-nama="{{ $jadwal->siswa?->nama }}">
                                    {{ $jadwal->hari }} {{ $jadwal->jam }} - {{ $jadwal->siswa?->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama siswa diisi otomatis setelah jadwal dipilih. --}}
                    <div class="mb-3">
                        <label class="form-label small fw-700 text-secondary">SISWA YANG MENGIKUTI KELAS</label>
                        <input type="hidden" name="siswa_id" id="input-presensi-siswa-id" required />
                        <input type="text" class="form-control rounded-3 py-2 bg-light" id="input-presensi-siswa-name" readonly placeholder="Pilih jadwal kelas terlebih dahulu" />
                    </div>

                    {{-- Pilih status kehadiran untuk catatan hari ini. --}}
                    <div class="mb-3">
                        <label class="form-label small fw-700 text-secondary">STATUS KEHADIRAN <span class="text-danger">*</span></label>
                        <input type="hidden" name="status" id="input-presensi-status" value="hadir" />
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary btn-sm flex-fill py-2 active" type="button" onclick="setStatus('hadir', this)">
                                <i class="bi bi-person-check me-1"></i>Hadir
                            </button>
                            <button class="btn btn-outline-warning btn-sm flex-fill py-2" type="button" onclick="setStatus('izin', this)">
                                <i class="bi bi-envelope-open me-1"></i>Izin
                            </button>
                            <button class="btn btn-outline-danger btn-sm flex-fill py-2" type="button" onclick="setStatus('alpha', this)">
                                <i class="bi bi-person-x me-1"></i>Alpha
                            </button>
                        </div>
                    </div>

                    {{-- Catatan opsional untuk menambahkan laporan atau alasan ketidakhadiran. --}}
                    <div class="mb-4">
                        <label class="form-label small fw-700 text-secondary">CATATAN / LAPORAN LATIHAN <span class="badge bg-light text-secondary ms-1 fw-normal">Opsional</span></label>
                        <textarea class="form-control rounded-3" name="catatan" rows="3" placeholder="Masukkan laporan perkembangan siswa atau catatan ketidakhadiran..."></textarea>
                    </div>

                    <button class="btn btn-primary w-100 py-2.5 rounded-3 fw-700 shadow-sm" type="submit">
                        <i class="bi bi-save me-1"></i>Simpan Presensi
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Riwayat presensi yang sudah dicatat sebelumnya. --}}
    <div class="col-12 col-lg-8">
        <div class="card-custom border shadow-sm rounded-4 bg-white h-100 overflow-hidden fade-in">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="bi bi-card-list me-2 text-primary fs-5"></i>
                    <h2 class="fw-800 text-main mb-0" style="font-size: 1.1rem;">Daftar Presensi Terkini</h2>
                </div>
                <div class="input-group input-group-sm" style="max-width: 200px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input id="history-search-input" type="text" class="form-control border-start-0 ps-0" placeholder="Cari..." />
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>SISWA</th>
                                <th>TANGGAL</th>
                                <th>JADWAL</th>
                                <th>STATUS</th>
                                <th>CATATAN</th>
                                <th style="width: 80px; text-align: right;">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="history-table-body">
                            @if($presensis->isEmpty())
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-clipboard-x fs-1 opacity-40 mb-3 d-block"></i>
                                        Belum ada riwayat presensi yang dicatat oleh Anda.
                                    </td>
                                </tr>
                            @else
                                {{-- Tampilkan tiap catatan presensi sebagai baris tabel. --}}
                                @foreach($presensis as $presensi)
                                    @php
                                        $statusClass = 'bg-success-light text-success border-success-subtle';
                                        if ($presensi->status === 'izin') {
                                            $statusClass = 'bg-warning-light text-warning border-warning-subtle';
                                        } elseif ($presensi->status === 'alpha') {
                                            $statusClass = 'bg-danger-light text-danger border-danger-subtle';
                                        }
                                    @endphp
                                    <tr class="history-row">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-800 text-white me-2.5" 
                                                     style="width: 32px; height: 32px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); font-size: 0.8rem;">
                                                    {{ strtoupper(substr($presensi->siswa?->nama ?? 'S', 0, 1)) }}
                                                </div>
                                                <span class="fw-800 text-main" style="font-size: 0.875rem;">
                                                    {{ $presensi->siswa?->nama }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-secondary small fw-600">
                                                {{ $presensi->tanggal->translatedFormat('d M Y') }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-secondary small">
                                                {{ $presensi->jadwal?->hari }} {{ $presensi->jadwal?->jam }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge border px-2.5 py-1.5 fw-600 rounded-pill {{ $statusClass }}">
                                                {{ ucfirst($presensi->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-secondary small d-inline-block text-truncate" style="max-width: 150px;" title="{{ $presensi->catatan }}">
                                                {{ $presensi->catatan ?? '—' }}
                                            </span>
                                        </td>
                                        <td style="text-align: right;">
                                            <form action="{{ route('pelatih.presensi.destroy', $presensi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan presensi ini? Sesi siswa akan disesuaikan otomatis.');" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger" type="submit" style="padding: 4px 8px;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script interaktif untuk mengatur status presensi dan memfilter riwayat. --}}
<script>
    function setStatus(status, btn) {
        document.getElementById('input-presensi-status').value = status;
        
        // Remove active class from all sibling buttons
        const container = btn.closest('.d-flex');
        container.querySelectorAll('button').forEach(b => b.classList.remove('active'));
        
        // Add active class to current button
        btn.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const selectJadwal = document.getElementById('input-presensi-jadwal');
        const inputSiswaId = document.getElementById('input-presensi-siswa-id');
        const inputSiswaName = document.getElementById('input-presensi-siswa-name');
        
        if (selectJadwal && inputSiswaId && inputSiswaName) {
            selectJadwal.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const siswaId = selectedOption.getAttribute('data-siswa-id');
                const siswaNama = selectedOption.getAttribute('data-siswa-nama');
                
                if (siswaId && siswaNama) {
                    inputSiswaId.value = siswaId;
                    inputSiswaName.value = siswaNama;
                } else {
                    inputSiswaId.value = '';
                    inputSiswaName.value = '';
                    inputSiswaName.placeholder = 'Pilih jadwal kelas terlebih dahulu';
                }
            });
        }

        const inputSearch = document.getElementById('history-search-input');
        if (inputSearch) {
            inputSearch.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.history-row');
                
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(term)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endsection
