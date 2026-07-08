@extends('layouts.app')

@section('content')
{{-- Dashboard siswa menampilkan informasi program, jadwal, dan riwayat presensi. --}}
<div class="fade-in">
    {{-- Banner sambutan yang menampilkan status sesi dan ucapan personal. --}}
    <div class="card-custom mb-4 overflow-hidden border-0 position-relative" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%); box-shadow: 0 10px 25px -5px rgba(37,99,235,0.25);">
        <!-- Wave vector backdrop -->
        <div class="position-absolute w-100 h-100 top-0 start-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1440 320%22%3E%3Cpath fill=%22%23fff%22 fill-opacity=%221%22 d=%22M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,250.7C672,235,768,181,864,170.7C960,160,1056,192,1152,202.7C1248,213,1344,203,1392,197.3L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z%22%3E%3C/path%3E%3C/svg%3E'); background-size: cover; background-position: bottom; pointer-events: none;"></div>
        
        <div class="card-body p-4 p-md-5 position-relative z-1">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white mb-3 mb-lg-0">
                    <span class="badge bg-white bg-opacity-20 px-3 py-1.5 rounded-pill text-white fw-600 mb-3" style="backdrop-filter: blur(4px); font-size: 0.78rem; letter-spacing: 0.5px;">BERANDA SISWA</span>
                    <h1 class="display-6 fw-800 mb-2" style="font-weight: 800; letter-spacing: -1px; text-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                        @php
                            $hour = date('H');
                            $greeting = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
                        @endphp
                        {{ $greeting }}, {{ $siswa?->nama ?? $user?->name ?? 'Siswa' }}! 🏊‍♂️
                    </h1>
                    <p class="lead mb-0 text-white text-opacity-85" style="font-size: 0.95rem; font-weight: 400; max-width: 500px;">
                        @if ($siswa?->program)
                            Semangat berlatih! Hari ini adalah hari yang baik untuk berenang dan meningkatkan teknik Anda.
                        @else
                            Akun Anda berhasil didaftarkan. Harap hubungi Admin jika program latihan Anda belum aktif.
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-inline-flex align-items-center gap-3 bg-white bg-opacity-10 p-3 rounded-4" style="backdrop-filter: blur(8px); border: 1px solid rgba(255,255,255,0.15);">
                        <div class="bg-white text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.5rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="text-start text-white">
                            <small class="d-block text-white text-opacity-70 small fw-600">SISA SESI LATIHAN</small>
                            <span class="fs-4 fw-800 d-block leading-1">{{ max(0, ($siswa?->total_sesi ?? 0) - ($siswa?->sesi_terpakai ?? 0)) }} Sesi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Empat kartu ringkasan untuk melihat program, jadwal, presensi, dan sisa sesi. --}}
    <div class="row g-3 mb-4">
        {{-- Kartu program latihan yang sedang aktif. --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background: rgba(37,99,235,0.06); color: var(--primary);">
                    <i class="bi bi-award"></i>
                </div>
                <h2>
                    @if ($siswa?->program)
                        @php
                            $programFull = $siswa->program->value;
                            $programShort = str_contains($programFull, 'WaterBabies') ? 'WaterBabies' : 
                                            (str_contains($programFull, 'SwimStars') ? 'SwimStars' :
                                            (str_contains($programFull, 'AquaFit') ? 'AquaFit' : 'SwimElite'));
                        @endphp
                        {{ $programShort }}
                    @else
                        -
                    @endif
                </h2>
                <p>Program Latihan</p>
                <div class="stat-trend">
                    <span class="badge" style="background: rgba(37,99,235,0.08); color: var(--primary);">{{ $siswa?->jenis_program?->value ?? 'Reguler' }}</span>
                </div>
            </div>
        </div>

        {{-- Kartu jumlah jadwal latihan yang sudah ditetapkan. --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background: rgba(22,163,74,0.06); color: var(--success);">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <h2>{{ $jadwals->count() }} Hari</h2>
                <p>Jadwal Pertemuan</p>
                <div class="stat-trend" style="color: var(--success);">
                    <i class="bi bi-clock-history me-1"></i> Rutin Mingguan
                </div>
            </div>
        </div>

        {{-- Kartu jumlah presensi yang sudah tercatat. --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background: rgba(147,51,234,0.06); color: #9333ea;">
                    <i class="bi bi-clipboard2-check"></i>
                </div>
                <h2>{{ $presensis->count() }} Kali</h2>
                <p>Presensi Masuk</p>
                <div class="stat-trend" style="color: #9333ea;">
                    <i class="bi bi-check-circle-fill me-1"></i> Kehadiran Tercatat
                </div>
            </div>
        </div>

        {{-- Kartu sisa sesi dengan progress bar visual. --}}
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card h-100">
                <div class="stat-icon" style="background: rgba(245,158,11,0.06); color: var(--warning);">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <h2>{{ max(0, ($siswa?->total_sesi ?? 0) - ($siswa?->sesi_terpakai ?? 0)) }} / {{ $siswa?->total_sesi ?? 0 }}</h2>
                <p>Sesi Tersisa</p>
                
                @php
                    $total = max(1, $siswa?->total_sesi ?? 1);
                    $terpakai = $siswa?->sesi_terpakai ?? 0;
                    $persen = round((max(0, $total - $terpakai) / $total) * 100);
                    $barColor = $persen <= 25 ? 'bg-danger' : ($persen <= 50 ? 'bg-warning' : 'bg-success');
                @endphp
                <div class="mt-3">
                    <div class="progress rounded-pill" style="height: 6px;">
                        <div class="progress-bar {{ $barColor }} rounded-pill" style="width: {{ $persen }}%"></div>
                    </div>
                    <small class="d-block text-muted text-end mt-1" style="font-size: 0.72rem;">{{ $persen }}% tersisa</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian bawah menampilkan jadwal terdekat dan riwayat presensi terbaru. --}}
    <div class="row g-3">
        {{-- Daftar jadwal latihan yang akan datang. --}}
        <div class="col-12 col-lg-6">
            <div class="card-custom h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-calendar3 me-2 text-primary"></i>Jadwal Terdaftar
                    </div>
                    <a href="{{ route('siswa.jadwal') }}" class="btn btn-light btn-sm text-primary fw-600" style="font-size: 0.77rem; border-radius: 8px;">Lihat Semua</a>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex flex-column gap-2.5">
                        @forelse ($jadwals as $jadwal)
                            {{-- Tampilkan tiap jadwal sebagai item ringkas dengan informasi coach dan lokasi. --}}
                            <div class="d-flex align-items-center p-3 rounded-4 border border-light" style="background: var(--bg-main); transition: transform 0.2s ease;">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-3 text-center d-flex flex-column justify-content-center align-items-center" style="width: 52px; height: 52px;">
                                    <span class="small fw-800" style="font-size: 0.75rem;">{{ strtoupper(substr($jadwal->hari, 0, 3)) }}</span>
                                    <span class="small fw-500" style="font-size: 0.65rem; opacity: 0.8;">{{ $jadwal->jam }}</span>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <strong class="d-block text-main" style="font-size: 0.88rem;">Coach {{ $jadwal->pelatih->nama ?? 'Belum ada Pelatih' }}</strong>
                                    <small class="text-secondary" style="font-size: 0.78rem;"><i class="bi bi-geo-alt me-1"></i>{{ $jadwal->lokasi }}</small>
                                </div>
                                <div>
                                    <span class="badge rounded-pill px-2.5 py-1 text-capitalize" style="font-size:0.68rem; background: #E0F2FE; color: #0369A1; border: 1px solid #BAE6FD;">{{ $jadwal->tipe ?? 'Reguler' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-calendar-x fs-2 mb-2 d-block text-opacity-50"></i>
                                Belum ada jadwal terdaftar untuk Anda.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Riwayat presensi terakhir siswa. --}}
        <div class="col-12 col-lg-6">
            <div class="card-custom h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-clock-history me-2 text-primary"></i>Presensi Terbaru
                    </div>
                    <a href="{{ route('siswa.presensi') }}" class="btn btn-light btn-sm text-primary fw-600" style="font-size: 0.77rem; border-radius: 8px;">Riwayat Lengkap</a>
                </div>
                <div class="card-body p-3">
                    <div class="d-flex flex-column gap-2.5">
                        @forelse ($presensis as $presensi)
                            {{-- Tampilkan status presensi terakhir dengan warna yang berbeda. --}}
                            @php
                                $badgeColor = $presensi->status === 'hadir' ? 'background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0;' : 
                                              ($presensi->status === 'izin' ? 'background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A;' : 
                                                                               'background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA;');
                            @endphp
                            <div class="d-flex align-items-center p-3 rounded-4 border border-light" style="background: var(--bg-main);">
                                <div class="text-center rounded-3 d-flex flex-column justify-content-center align-items-center border" style="width: 52px; height: 52px; background: #fff;">
                                    <i class="bi bi-check-square text-secondary fs-5"></i>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <strong class="d-block text-main" style="font-size: 0.88rem;">
                                        @if($presensi->tanggal)
                                            {{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d F Y') }}
                                        @else
                                            -
                                        @endif
                                    </strong>
                                    <small class="text-secondary" style="font-size: 0.78rem;">Sesi Hari: {{ $presensi->jadwal->hari ?? '-' }}</small>
                                </div>
                                <div>
                                    <span class="badge rounded-pill px-3 py-1 text-uppercase" style="font-size:0.68rem; {{ $badgeColor }}">
                                        {{ $presensi->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="bi bi-clipboard2-x fs-2 mb-2 d-block text-opacity-50"></i>
                                Belum ada riwayat kehadiran tercatat.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
