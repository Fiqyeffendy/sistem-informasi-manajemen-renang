@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan jadwal latihan siswa dalam bentuk kartu. --}}
<div class="fade-in">
    {{-- Header halaman yang menampilkan jumlah pertemuan aktif. --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1>Jadwal Latihan</h1>
            <p>Daftar rincian jadwal latihan renang rutin Anda setiap minggunya</p>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-600" style="font-size: 0.8rem;">
            <i class="bi bi-calendar-check-fill me-1"></i> {{ $jadwals->count() }} Pertemuan Aktif
        </span>
    </div>

    {{-- Kartu jadwal latihan siswa yang disusun per hari. --}}
    <div class="row g-3">
        @forelse ($jadwals as $jadwal)
            @php
                $initials = '';
                if ($jadwal->pelatih && $jadwal->pelatih->nama) {
                    $words = explode(' ', trim($jadwal->pelatih->nama));
                    $initials = strtoupper(substr($words[0], 0, 1));
                    if (count($words) > 1) {
                        $initials .= strtoupper(substr($words[1], 0, 1));
                    }
                } else {
                    $initials = 'P';
                }
                
                // Card accent color
                $badgeBg = $jadwal->tipe === 'backup' ? '#FEF3C7' : '#E0F2FE';
                $badgeText = $jadwal->tipe === 'backup' ? '#B45309' : '#0369A1';
                $badgeBorder = $jadwal->tipe === 'backup' ? '#FDE68A' : '#BAE6FD';
            @endphp
            <div class="col-12 col-md-6 col-xxl-4">
                <div class="card-custom h-100 position-relative transition-all" style="border: 1px solid var(--border); background: var(--surface);">
                    <div class="card-body p-4">
                        {{-- Baris atas menampilkan hari dan tipe kelas. --}}

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="fs-5 fw-800 text-main" style="letter-spacing: -0.5px;">{{ $jadwal->hari }}</span>
                            <span class="badge rounded-pill px-2.5 py-1 text-capitalize" style="font-size: 0.68rem; background: {{ $badgeBg }}; color: {{ $badgeText }}; border: 1px solid {{ $badgeBorder }};">
                                {{ $jadwal->tipe ?? 'Reguler' }}
                            </span>
                        </div>

                        {{-- Bagian informasi pelatih dan kontak visual. --}}

                        <div class="d-flex align-items-center mb-4 p-3 rounded-4" style="background: var(--bg-main);">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-800 text-white" style="width: 44px; height: 44px; background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%); font-size: 0.85rem; box-shadow: 0 4px 6px rgba(37,99,235,0.15);">
                                {{ $initials }}
                            </div>
                            <div class="ms-3">
                                <small class="text-secondary d-block" style="font-size: 0.72rem; font-weight: 600; letter-spacing: 0.2px;">PELATIH</small>
                                <span class="fw-700 text-main" style="font-size: 0.88rem;">{{ $jadwal->pelatih->nama ?? 'Pelatih belum ditentukan' }}</span>
                            </div>
                        </div>

                        {{-- Detail jam, durasi, dan lokasi latihan. --}}

                        <div class="d-flex flex-column gap-2 mb-2">
                            <div class="d-flex align-items-center text-secondary" style="font-size: 0.82rem;">
                                <i class="bi bi-clock me-2.5 text-primary"></i>
                                <span>Jam Mulai: <strong>{{ $jadwal->jam }}</strong></span>
                            </div>
                            <div class="d-flex align-items-center text-secondary" style="font-size: 0.82rem;">
                                <i class="bi bi-hourglass-split me-2.5 text-primary"></i>
                                <span>Durasi: <strong>{{ $jadwal->durasi ?? '60 Menit' }}</strong></span>
                            </div>
                            <div class="d-flex align-items-center text-secondary" style="font-size: 0.82rem;">
                                <i class="bi bi-geo-alt me-2.5 text-primary"></i>
                                <span class="text-truncate" title="{{ $jadwal->lokasi }}">Lokasi: <strong>{{ $jadwal->lokasi }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Accent Border -->
                    <div class="position-absolute bottom-0 start-0 w-100" style="height: 4px; background: {{ $jadwal->tipe === 'backup' ? 'var(--warning)' : 'var(--primary)' }};"></div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-custom text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-calendar-x text-muted display-4 mb-3 d-block text-opacity-50"></i>
                        <h4 class="fw-700 text-main">Belum Ada Jadwal</h4>
                        <p class="text-secondary mx-auto" style="max-width: 380px;">Belum ada jadwal latihan renang yang ditetapkan untuk akun Anda saat ini. Hubungi admin untuk informasi lebih lanjut.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
