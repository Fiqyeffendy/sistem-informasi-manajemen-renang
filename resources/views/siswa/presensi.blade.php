@extends('layouts.app')

@section('content')
<div class="fade-in">
    <!-- Header Section -->
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1>Riwayat Kehadiran</h1>
            <p>Lacak kehadiran latihan renang Anda yang dicatat oleh Pelatih</p>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-600" style="font-size: 0.8rem;">
            <i class="bi bi-journal-check me-1"></i> Total {{ $presensis->count() }} Data Presensi
        </span>
    </div>

    <!-- Attendance Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Hadir Card -->
        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center gap-3 p-3">
                <div class="stat-icon mb-0" style="background: rgba(22,163,74,0.06); color: var(--success); width: 46px; height: 46px; border-radius: 12px; font-size: 1.25rem;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div>
                    <h3 class="fw-800 text-main mb-0" style="font-size: 1.5rem; line-height: 1;">{{ $presensis->where('status', 'hadir')->count() }}</h3>
                    <p class="text-secondary small fw-500 mb-0">Total Hadir</p>
                </div>
            </div>
        </div>

        <!-- Izin Card -->
        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center gap-3 p-3">
                <div class="stat-icon mb-0" style="background: rgba(245,158,11,0.06); color: var(--warning); width: 46px; height: 46px; border-radius: 12px; font-size: 1.25rem;">
                    <i class="bi bi-info-circle"></i>
                </div>
                <div>
                    <h3 class="fw-800 text-main mb-0" style="font-size: 1.5rem; line-height: 1;">{{ $presensis->where('status', 'izin')->count() }}</h3>
                    <p class="text-secondary small fw-500 mb-0">Total Izin</p>
                </div>
            </div>
        </div>

        <!-- Alpha Card -->
        <div class="col-12 col-md-4">
            <div class="stat-card d-flex align-items-center gap-3 p-3">
                <div class="stat-icon mb-0" style="background: rgba(220,38,38,0.06); color: var(--danger); width: 46px; height: 46px; border-radius: 12px; font-size: 1.25rem;">
                    <i class="bi bi-x-circle"></i>
                </div>
                <div>
                    <h3 class="fw-800 text-main mb-0" style="font-size: 1.5rem; line-height: 1;">{{ $presensis->where('status', 'alpha')->count() }}</h3>
                    <p class="text-secondary small fw-500 mb-0">Total Absen (Alpha)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Table -->
    <div class="card-custom">
        <div class="card-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-table text-primary"></i>
                <span>Tabel Presensi Masuk</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 80px;">No</th>
                            <th>Tanggal Latihan</th>
                            <th>Hari &amp; Jam</th>
                            <th>Pelatih</th>
                            <th style="width: 140px;">Status</th>
                            <th>Catatan Pelatih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($presensis as $index => $presensi)
                            @php
                                $badgeColor = $presensi->status === 'hadir' ? 'background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0;' : 
                                              ($presensi->status === 'izin' ? 'background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A;' : 
                                                                               'background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA;');
                            @endphp
                            <tr>
                                <td><span class="text-secondary fw-500">{{ $index + 1 }}</span></td>
                                <td>
                                    <span class="fw-700 text-main">
                                        {{ $presensi->tanggal ? $presensi->tanggal->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary fw-500">
                                        {{ $presensi->jadwal->hari ?? '-' }} ({{ $presensi->jadwal->jam ?? '-' }})
                                    </span>
                                </td>
                                <td>
                                    <span class="text-main fw-600">
                                        Coach {{ $presensi->pelatih->nama ?? $presensi->jadwal->pelatih->nama ?? 'Pelatih' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-2.5 py-1 text-uppercase" style="font-size: 0.68rem; {{ $badgeColor }}">
                                        {{ $presensi->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary" style="font-size: 0.85rem;">{{ $presensi->catatan ?? '-' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-journal-x fs-2 mb-2 d-block text-opacity-50"></i>
                                    Belum ada data presensi tercatat untuk Anda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
