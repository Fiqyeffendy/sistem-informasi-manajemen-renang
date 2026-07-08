@extends('layouts.app')

@section('content')
{{-- Halaman ini menampilkan sisa sesi dan detail paket latihan siswa. --}}
<div class="fade-in">
    {{-- Header halaman yang menampilkan status paket aktif. --}}
    <div class="page-header d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h1>Sisa Sesi &amp; Informasi Paket</h1>
            <p>Rincian kuota sesi latihan renang aktif dan informasi program les Anda</p>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-600" style="font-size: 0.8rem;">
            <i class="bi bi-shield-check me-1"></i> Paket Aktif
        </span>
    </div>

    <div class="row g-4">
        {{-- Kartu progres sisa sesi dan kuota latihan. --}}
        <div class="col-12 col-lg-5">
            <div class="card-custom h-100 border-0 shadow-sm" style="background: var(--surface);">
                <div class="card-header border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-hourglass-split text-primary"></i>
                        <span>Kuotasi Sesi Latihan</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    @php
                        {{-- Hitung sisa sesi dan status visual berdasarkan kuota yang tersisa. --}}
                        $total = max(1, $siswa?->total_sesi ?? 1);
                        $terpakai = $siswa?->sesi_terpakai ?? 0;
                        $sisa = max(0, $total - $terpakai);
                        $persen = round(($sisa / $total) * 100);
                        
                        // Status styling based on remaining sessions
                        if ($sisa <= 2) {
                            $statusTitle = 'Segera Isi Ulang!';
                            $statusClass = 'badge-danger bg-danger bg-opacity-10 text-danger';
                            $barClass = 'bg-danger';
                        } elseif ($sisa <= 5) {
                            $statusTitle = 'Sesi Hampir Habis';
                            $statusClass = 'badge-warning bg-warning bg-opacity-10 text-warning';
                            $barClass = 'bg-warning';
                        } else {
                            $statusTitle = 'Kuota Aktif';
                            $statusClass = 'badge-success bg-success bg-opacity-10 text-success';
                            $barClass = 'bg-success';
                        }
                    @endphp

                    {{-- Angka besar untuk menunjukkan sisa kuota. --}}

                    <div class="text-center py-3 mb-4 rounded-4" style="background: var(--bg-main);">
                        <span class="d-block text-secondary small fw-600 mb-1" style="letter-spacing: 0.5px;">SISA KUOTA</span>
                        <span class="display-4 fw-900 text-main d-block leading-1 mb-2">{{ $sisa }}</span>
                        <span class="badge rounded-pill px-3 py-1.5 fw-700 {{ $statusClass }}" style="font-size: 0.72rem;">{{ $statusTitle }}</span>
                    </div>

                    {{-- Progress bar yang merepresentasikan persentase kuota. --}}

                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1.5" style="font-size: 0.82rem;">
                            <span class="text-secondary fw-500">Persentase Kuota</span>
                            <span class="fw-700 text-main">{{ $persen }}%</span>
                        </div>
                        <div class="progress rounded-pill shadow-inner" style="height: 10px; background: var(--border);">
                            <div class="progress-bar {{ $barClass }} progress-bar-striped progress-bar-animated rounded-pill" style="width: {{ $persen }}%"></div>
                        </div>
                    </div>

                    {{-- Ringkasan total kuota, terpakai, dan sisa sesi. --}}

                    <div class="d-flex justify-content-between py-2 border-bottom border-light" style="font-size: 0.85rem;">
                        <span class="text-secondary">Total Kuota yang Dibeli</span>
                        <strong class="text-main">{{ $total }} Sesi</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom border-light" style="font-size: 0.85rem;">
                        <span class="text-secondary">Sesi Latihan Terpakai</span>
                        <strong class="text-main">{{ $terpakai }} Sesi</strong>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="font-size: 0.85rem;">
                        <span class="text-secondary">Sisa Sesi Tersisa</span>
                        <strong class="text-primary">{{ $sisa }} Sesi</strong>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail program, jenis kelas, dan lokasi latihan. --}}
        <div class="col-12 col-lg-7">
            <div class="card-custom h-100 border-0 shadow-sm" style="background: var(--surface);">
                <div class="card-header border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle text-primary"></i>
                        <span>Detail Program &amp; Kelas Les</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Program -->
                        <div class="col-12 col-sm-6">
                            <div class="p-3.5 rounded-4 border border-light" style="background: var(--bg-main);">
                                <small class="text-secondary d-block mb-1 fw-600" style="font-size: 0.72rem; letter-spacing: 0.2px;">PROGRAM LES</small>
                                <span class="fw-700 text-main" style="font-size: 0.95rem;">
                                    {{ $siswa?->program?->value ?? 'Belum ditentukan' }}
                                </span>
                            </div>
                        </div>

                        <!-- Jenis Program -->
                        <div class="col-12 col-sm-6">
                            <div class="p-3.5 rounded-4 border border-light" style="background: var(--bg-main);">
                                <small class="text-secondary d-block mb-1 fw-600" style="font-size: 0.72rem; letter-spacing: 0.2px;">TIPE KELAS</small>
                                <span class="fw-700 text-main" style="font-size: 0.95rem;">
                                    {{ $siswa?->jenis_program?->value ?? 'Belum ditentukan' }}
                                </span>
                            </div>
                        </div>

                        <!-- Lokasi Les -->
                        <div class="col-12">
                            <div class="p-3.5 rounded-4 border border-light" style="background: var(--bg-main);">
                                <small class="text-secondary d-block mb-1 fw-600" style="font-size: 0.72rem; letter-spacing: 0.2px;">LOKASI POOL / LATIHAN</small>
                                <span class="fw-700 text-main" style="font-size: 0.95rem;">
                                    {{ $siswa?->lokasi_les?->value ?? 'Belum ditentukan' }}
                                </span>
                            </div>
                        </div>

                        <!-- Jadwal overview -->
                        <div class="col-12">
                            <div class="p-3.5 rounded-4 border border-light" style="background: var(--bg-main);">
                                <small class="text-secondary d-block mb-1 fw-600" style="font-size: 0.72rem; letter-spacing: 0.2px;">INFO KETENTUAN PAKET</small>
                                <p class="text-secondary mb-0" style="font-size: 0.82rem; line-height: 1.5;">
                                    Setiap paket memiliki masa berlaku kuota tersendiri. Mohon lakukan koordinasi dengan admin atau pelatih jika Anda berencana melakukan izin ketidakhadiran minimal 24 jam sebelum kelas dimulai agar sesi tidak terpotong hangus.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
