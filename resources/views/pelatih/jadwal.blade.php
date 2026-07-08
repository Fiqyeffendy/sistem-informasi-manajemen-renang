@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan jadwal mengajar pelatih beserta detail kelas. --}}

{{-- Header halaman dengan pencarian jadwal. --}}
<div class="page-header fade-in d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <div>
        <h1 class="fw-800 mb-1" style="font-size: 1.5rem; letter-spacing: -0.5px;">Jadwal Mengajar Saya</h1>
        <p class="text-secondary small mb-0">Kelola dan lihat jadwal mengajar mingguan Anda.</p>
    </div>
    <div class="d-flex gap-2">
        <div class="input-group input-group-sm" style="max-width: 240px;">
            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
            <input id="jadwal-search-input" type="text" class="form-control border-start-0 ps-0" placeholder="Cari jadwal..." />
        </div>
    </div>
</div>

{{-- Tabel daftar jadwal mengajar pelatih. --}}
<div class="card-custom border shadow-sm rounded-4 bg-white overflow-hidden fade-in">
    <div class="table-responsive">
        <table class="table table-custom table-hover mb-0 align-middle">
            <thead>
                <tr>
                    <th style="width: 120px;">HARI</th>
                    <th style="width: 100px;">JAM</th>
                    <th>NAMA SISWA</th>
                    <th>LOKASI LES</th>
                    <th>DURASI</th>
                    <th>TIPE</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody id="jadwal-table-body">
                @if($jadwals->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center text-muted py-5">
                            <i class="bi bi-calendar3 fs-1 opacity-40 mb-3 d-block"></i>
                            Belum ada jadwal mengajar yang terdaftar dengan Anda.
                        </td>
                    </tr>
                @else
                    @foreach($jadwals as $jadwal)
                        @php
                            $tipeBadge = $jadwal->tipe === 'backup'
                                ? 'bg-warning-light text-warning border-warning-subtle'
                                : 'bg-primary-light text-primary border-primary-subtle';
                        @endphp
                        <tr class="jadwal-row">
                            <td>
                                <span class="fw-800 text-main text-uppercase" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                    {{ $jadwal->hari }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-700 text-primary" style="font-size: 0.9rem;">
                                    {{ $jadwal->jam }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center fw-800 text-white me-2.5" 
                                         style="width: 32px; height: 32px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); font-size: 0.8rem;">
                                        {{ strtoupper(substr($jadwal->siswa?->nama ?? 'S', 0, 1)) }}
                                    </div>
                                    <span class="fw-800 text-main" style="font-size: 0.875rem;">
                                        {{ $jadwal->siswa?->nama ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="text-secondary small">
                                    <i class="bi bi-geo-alt me-1 text-primary opacity-60"></i>{{ $jadwal->lokasi }}
                                </span>
                            </td>
                            <td>
                                <span class="text-secondary small">
                                    <i class="bi bi-clock me-1 text-primary opacity-60"></i>{{ $jadwal->durasi }}
                                </span>
                            </td>
                            <td>
                                <span class="badge border px-2.5 py-1.5 fw-600 rounded-pill {{ $tipeBadge }}">
                                    {{ ucfirst($jadwal->tipe) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge px-2.5 py-1.5 rounded-pill border {{ $jadwal->status === 'aktif' ? 'bg-success-light text-success border-success-subtle' : 'bg-secondary-light text-secondary border-secondary-subtle' }} fw-600">
                                    {{ ucfirst($jadwal->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

{{-- Script pencarian sederhana untuk menyaring jadwal pelatih berdasarkan kata kunci. --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('jadwal-search-input');
        if (input) {
            input.addEventListener('input', function() {
                const term = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.jadwal-row');
                
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
