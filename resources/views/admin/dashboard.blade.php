@extends('layouts.app')

@section('content')
{{-- Dashboard admin menampilkan ringkasan data, pendaftaran, dan statistik kehadiran hari ini. --}}
<style>
    /* ── Dashboard Layout & Spacing ── */
    .dash-header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .dash-greeting-wrap h2 {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.6px;
        margin: 0 0 0.25rem;
    }
    .dash-greeting-wrap p {
        font-size: 0.88rem;
        color: var(--text-secondary);
        margin: 0;
        font-weight: 500;
    }

    /* ── Stat Cards Grid (4 Columns) ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .stat-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-card);
        padding: 1.5rem;
        position: relative;
        box-shadow: var(--shadow-sm);
        transition: transform var(--transition-base), box-shadow var(--transition-base);
    }
    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    .stat-box-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }
    .stat-box-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
    .stat-box-icon.siswa-icon { background: rgba(37,99,235,0.06); color: var(--primary); }
    .stat-box-icon.kelas-icon { background: rgba(22,163,74,0.06); color: var(--success); }
    .stat-box-icon.pelatih-icon { background: rgba(245,158,11,0.06); color: var(--warning); }
    .stat-box-icon.hadir-icon { background: rgba(147,51,234,0.06); color: #9333ea; }

    .stat-box-value {
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -1px;
        line-height: 1;
        margin-bottom: 0.375rem;
    }
    .stat-box-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
        font-weight: 600;
        margin: 0;
    }

    /* ── Schedule Card ── */
    .sched-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    .sched-box {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: var(--surface);
        transition: transform var(--transition-base);
    }
    .sched-box:hover { transform: translateX(3px); }
    
    /* Highlighted class */
    .sched-box.active {
        background: #F0FDF4 !important;
        border-color: #BBF7D0 !important;
    }

    .sched-time-col {
        min-width: 60px;
        font-size: 0.95rem;
        font-weight: 800;
        color: var(--text-main);
        letter-spacing: -0.2px;
    }
    .sched-info-col {
        flex: 1;
        padding-left: 0.75rem;
    }
    .sched-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.125rem;
    }
    .sched-sub {
        font-size: 0.78rem;
        color: var(--text-secondary);
        font-weight: 500;
    }
    .sched-badge-col {
        text-align: right;
    }
    .sched-badge-col .label-siswa {
        font-size: 0.78rem;
        color: var(--text-secondary);
        font-weight: 600;
    }

    /* ── Quick Actions Grid ── */
    .q-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }
    .q-btn {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-card);
        padding: 1.25rem 0.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        color: var(--text-main);
        text-decoration: none;
        font-size: 0.78rem;
        font-weight: 600;
        transition: all var(--transition-base);
        text-align: center;
    }
    .q-btn:hover {
        background: var(--bg-main);
        border-color: var(--border-strong);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
    .q-btn-icon-wrap {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.05rem;
    }
    .q-btn:nth-child(1) .q-btn-icon-wrap { background: rgba(37,99,235,0.06); color: var(--primary); }
    .q-btn:nth-child(2) .q-btn-icon-wrap { background: rgba(22,163,74,0.06); color: var(--success); }
    .q-btn:nth-child(3) .q-btn-icon-wrap { background: rgba(245,158,11,0.06); color: var(--warning); }
    .q-btn:nth-child(4) .q-btn-icon-wrap { background: rgba(147,51,234,0.06); color: #9333ea; }
    .q-btn:nth-child(5) .q-btn-icon-wrap { background: rgba(6,182,212,0.06); color: #06b6d4; }
    .q-btn:nth-child(6) .q-btn-icon-wrap { background: rgba(100,116,139,0.06); color: var(--text-secondary); }

    /* ── Coach Status Row ── */
    .coach-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid var(--border);
    }
    .coach-row:last-child { border-bottom: none; }
    .coach-left-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .coach-initials-avatar {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary);
        display: flex; align-items: center; justify-content: center;
        font-size: 0.78rem; font-weight: 700;
    }
    .coach-name {
        font-size: 0.855rem;
        font-weight: 700;
        color: var(--text-main);
        display: block;
        line-height: 1.3;
    }
    .coach-subtext {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    /* ── Custom SVGs Chart ── */
    .chart-container-svg {
        position: relative;
        width: 100%;
        height: 200px;
    }
    
    /* ── Table custom spacing ── */
    .table-pendaftaran td {
        padding: 1.1rem 1.25rem;
    }
</style>

<div id="dashboard-admin" class="section fade-in">

    {{-- Header halaman berisi sapaan admin dan tombol aksi cepat. --}}
    <div class="dash-header-section">
        <div class="dash-greeting-wrap">
            <h2 id="welcome-greeting">Selamat pagi, Admin 👏</h2>
            <p id="welcome-subtext">Sabtu, 29 Juni 2024 . Berikut ringkasan aktivitas hari ini</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-secondary btn-sm" onclick="location.reload()" style="height:36px;">
                <i class="bi bi-arrow-clockwise"></i> Segarkan
            </button>
            <a href="{{ route('admin.siswa') }}" class="btn btn-primary btn-sm" style="height:36px;">
                <i class="bi bi-plus-lg"></i> Tambah Siswa
            </a>
        </div>
    </div>

    {{-- Empat kartu KPI ringkas untuk melihat status utama sistem. --}}
    <div class="stat-grid">
        {{-- Kartu jumlah siswa aktif yang terdaftar. --}}
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon siswa-icon"><i class="bi bi-people"></i></div>
                <span class="badge badge-success" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Siswa</span>
            </div>
            <div class="stat-box-value" id="stat-siswa-val">{{ $totalSiswa }}</div>
            <p class="stat-box-label">Total Siswa Aktif</p>
        </div>
        {{-- Kartu jumlah kelas yang sedang berjalan. --}}
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon kelas-icon"><i class="bi bi-calendar-check"></i></div>
                <span class="badge badge-success" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Aktif</span>
            </div>
            <div class="stat-box-value" id="stat-kelas-val">{{ $activeKelas }}</div>
            <p class="stat-box-label">Kelas Berjalan</p>
        </div>
        {{-- Kartu jumlah pelatih aktif. --}}
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon pelatih-icon"><i class="bi bi-person-badge"></i></div>
                <span class="badge badge-success" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Pelatih</span>
            </div>
            <div class="stat-box-value" id="stat-pelatih-val">{{ $totalPelatih }}</div>
            <p class="stat-box-label">Pelatih Aktif</p>
        </div>
        {{-- Kartu jumlah kehadiran hari ini. --}}
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon hadir-icon"><i class="bi bi-clipboard2-check"></i></div>
                <span class="badge badge-alpha" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Presensi</span>
            </div>
            <div class="stat-box-value" id="stat-kehadiran-val">{{ $todayPresensiCount }}</div>
            <p class="stat-box-label">Kehadiran Hari Ini</p>
        </div>
    </div>

    {{-- Bagian jadwal hari ini dan tren kehadiran dalam bentuk kartu. --}}
    <div class="row g-3 mb-4">
        {{-- Daftar jadwal yang berlangsung hari ini. --}}
        <div class="col-lg-6">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Jadwal Hari Ini</span>
                        <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;" id="dash-date-sub">{{ $todayIndonesian }}, {{ now()->translatedFormat('d F Y') }}</div>
                    </div>
                    <span class="badge badge-info" id="dash-total-sesi-badge">{{ $todayJadwals->count() }} Sesi</span>
                </div>
                <div class="card-body">
                    <div class="sched-list" id="dash-sched-container">
                        @if($todayJadwals->isEmpty())
                            <div class="text-center py-5 text-muted small">
                                <i class="bi bi-calendar-x fs-3 d-block opacity-40 mb-2"></i>
                                Tidak ada jadwal hari ini ({{ $todayIndonesian }}).
                            </div>
                        @else
                            {{-- Tampilkan tiap jadwal sebagai baris yang ringkas dan mudah dibaca. --}}
                            @foreach($todayJadwals as $jadwal)
                                <div class="sched-box">
                                    <div class="sched-time-col">{{ \Carbon\Carbon::parse($jadwal->jam)->format('H:i') }}</div>
                                    <div class="sched-info-col">
                                        @php
                                            $progVal = $jadwal->siswa?->program instanceof \App\Enums\Program ? $jadwal->siswa?->program->value : (string) $jadwal->siswa?->program;
                                        @endphp
                                        <div class="sched-title">{{ explode(' (', $progVal)[0] }}</div>
                                        <div class="sched-sub">Coach {{ $jadwal->pelatih?->nama }} . {{ $jadwal->lokasi }}</div>
                                    </div>
                                    <div class="sched-badge-col">
                                        <span class="label-siswa">{{ $jadwal->siswa?->nama }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik tren kehadiran selama beberapa minggu terakhir. --}}
        <div class="col-lg-6">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Tren Kehadiran</span>
                        <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;">8 minggu terakhir</div>
                    </div>
                    <div class="d-flex align-items-center gap-3" style="font-size: 0.77rem; font-weight: 600;">
                        <span class="d-flex align-items-center gap-1" style="color:var(--primary);"><i class="bi bi-circle-fill" style="font-size:6px;"></i> Hadir</span>
                        <span class="d-flex align-items-center gap-1" style="color:var(--danger);"><i class="bi bi-circle-fill" style="font-size:6px;"></i> Absen</span>
                        <span class="d-flex align-items-center gap-1" style="color:var(--warning);"><i class="bi bi-circle-fill" style="font-size:6px;"></i> Terlambat</span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 250px;">
                    <div class="chart-container-svg">
                        <!-- Premium SVG Line Chart -->
                        <svg viewBox="0 0 500 180" width="100%" height="100%" preserveAspectRatio="none">
                            <!-- Grid Lines -->
                            <line x1="0" y1="40" x2="500" y2="40" stroke="#f1f5f9" stroke-width="1.5" />
                            <line x1="0" y1="80" x2="500" y2="80" stroke="#f1f5f9" stroke-width="1.5" />
                            <line x1="0" y1="120" x2="500" y2="120" stroke="#f1f5f9" stroke-width="1.5" />
                            <line x1="0" y1="160" x2="500" y2="160" stroke="#e2e8f0" stroke-width="1.5" />

                            <!-- Axes Labels Y -->
                            <text x="5" y="45" fill="#94a3b8" font-size="9" font-weight="600">60</text>
                            <text x="5" y="85" fill="#94a3b8" font-size="9" font-weight="600">45</text>
                            <text x="5" y="125" fill="#94a3b8" font-size="9" font-weight="600">30</text>
                            <text x="5" y="165" fill="#94a3b8" font-size="9" font-weight="600">15</text>

                            <!-- Gradient fill below path -->
                            <defs>
                                <linearGradient id="chart-fill-grad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#2563eb" stop-opacity="0.08" />
                                    <stop offset="100%" stop-color="#2563eb" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            
                            <path d="{{ $areaD }}" fill="url(#chart-fill-grad)" />

                            <path d="{{ $pathD }}" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" />

                            @foreach($weeksData as $index => $value)
                                @php
                                    $x = 40 + ($index * 60);
                                    $y = 160 - min(120, $value * 2);
                                @endphp
                                <circle cx="{{ $x }}" cy="{{ $y }}" r="4.5" fill="#fff" stroke="#2563eb" stroke-width="2.5" />
                            @endforeach
                        </svg>
                    </div>
                    <!-- X labels -->
                    <div class="d-flex justify-content-between px-4 pt-2 text-muted fw-600" style="font-size: 0.72rem; letter-spacing: 0.2px;">
                        @foreach($weeksLabel as $label)
                             <span>{{ $label }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Bagian status pelatih, distribusi sesi, dan aksi cepat admin. --}}
    <div class="row g-3 mb-4">
        {{-- Status ketersediaan pelatih hari ini. --}}
        <div class="col-lg-4">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Status Pelatih</span>
                        <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;">Ketersediaan hari ini</div>
                    </div>
                </div>
                <div class="card-body">
                    @if($coaches->isEmpty())
                        <div class="text-center text-muted py-5 small">
                            <i class="bi bi-person-badge fs-2 d-block opacity-40 mb-2"></i>
                            Belum ada pelatih terdaftar.
                        </div>
                    @else
                        {{-- Tampilkan tiap pelatih dengan jumlah siswa dan sesi aktif. --}}
                        @foreach($coaches as $coach)
                            @php
                                $words = explode(' ', $coach->nama);
                                $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                                $statusClass = $coach->status === 'aktif' ? 'badge-hadir' : 'badge-info';
                                $statusText = $coach->status === 'aktif' ? 'Available' : 'On Leave';
                            @endphp
                            <div class="coach-row">
                                <div class="coach-left-info">
                                    <div class="coach-initials-avatar">{{ $initials }}</div>
                                    <div>
                                        <span class="coach-name">{{ $coach->nama }}</span>
                                        <span class="coach-subtext">{{ $coach->total_siswa }} siswa . {{ $coach->total_sesi }} sesi</span>
                                    </div>
                                </div>
                                <span class="badge {{ $statusClass }}" style="font-size:0.68rem; padding:0.25rem 0.5rem;">{{ $statusText }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        {{-- Grafik distribusi sesi per hari untuk minggu ini. --}}
        <div class="col-lg-4">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Sesi per Hari</span>
                        <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;">Distribusi minggu ini</div>
                    </div>
                </div>
                <div class="card-body d-flex flex-column justify-content-between" style="min-height: 220px;">
                    <!-- Simple Sleek SVG Bar Chart -->
                    <div style="height: 140px; width: 100%;">
                        <svg viewBox="0 0 300 140" width="100%" height="100%" preserveAspectRatio="none">
                            <!-- Grid Y lines -->
                            <line x1="20" y1="20" x2="300" y2="20" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="20" y1="50" x2="300" y2="50" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="20" y1="80" x2="300" y2="80" stroke="#f1f5f9" stroke-width="1" />
                            <line x1="20" y1="110" x2="300" y2="110" stroke="#e2e8f0" stroke-width="1" />

                            <!-- Y Labels -->
                            <text x="0" y="24" fill="#94a3b8" font-size="8" font-weight="600">8</text>
                            <text x="0" y="54" fill="#94a3b8" font-size="8" font-weight="600">6</text>
                            <text x="0" y="84" fill="#94a3b8" font-size="8" font-weight="600">4</text>
                            <text x="0" y="114" fill="#94a3b8" font-size="8" font-weight="600">2</text>
                            <text x="0" y="136" fill="#94a3b8" font-size="8" font-weight="600">0</text>

                            <!-- Rounded Columns Bars -->
                            @php
                                $xCoords = [
                                    'Senin' => 40,
                                    'Selasa' => 78,
                                    'Rabu' => 116,
                                    'Kamis' => 154,
                                    'Jumat' => 192,
                                    'Sabtu' => 230,
                                    'Minggu' => 268
                                ];
                            @endphp
                            @foreach($sesiChartData as $day => $count)
                                @php
                                    $height = min(90, $count * 10);
                                    $y = 110 - $height;
                                    $x = $xCoords[$day];
                                @endphp
                                @if($height > 0)
                                    <rect x="{{ $x }}" y="{{ $y }}" width="14" height="{{ $height }}" rx="4" fill="#2563eb" />
                                @else
                                    <rect x="{{ $x }}" y="108" width="14" height="2" rx="1" fill="#e2e8f0" />
                                @endif
                            @endforeach
                        </svg>
                    </div>
                    <!-- X labels -->
                    <div class="d-flex justify-content-between px-2 text-muted fw-600" style="font-size: 0.72rem; padding-left: 28px !important;">
                        <span>Mon</span>
                        <span>Tue</span>
                        <span>Wed</span>
                        <span>Thu</span>
                        <span>Fri</span>
                        <span>Sat</span>
                        <span>Sun</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol navigasi cepat untuk tindakan rutin admin. --}}
        <div class="col-lg-4">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Aksi Cepat</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="q-grid">
                        <a href="{{ route('admin.siswa') }}" class="q-btn">
                            <div class="q-btn-icon-wrap"><i class="bi bi-person-plus"></i></div>
                            <span>Tambah Siswa</span>
                        </a>
                        <a href="{{ route('admin.presensi') }}" class="q-btn">
                            <div class="q-btn-icon-wrap"><i class="bi bi-clipboard2-check"></i></div>
                            <span>Catat Kehadiran</span>
                        </a>
                        <a href="{{ route('admin.jadwal') }}" class="q-btn">
                            <div class="q-btn-icon-wrap"><i class="bi bi-calendar3"></i></div>
                            <span>Buat Jadwal</span>
                        </a>
                        <a href="{{ route('admin.laporan') }}" class="q-btn">
                            <div class="q-btn-icon-wrap"><i class="bi bi-bar-chart-line"></i></div>
                            <span>Lihat Laporan</span>
                        </a>
                        <a href="{{ route('admin.sesi') }}" class="q-btn">
                            <div class="q-btn-icon-wrap"><i class="bi bi-hourglass-split"></i></div>
                            <span>Sisa Sesi</span>
                        </a>
                        <a href="#" class="q-btn" onclick="alert('Ekspor data pendaftaran sedang diproses...')">
                            <div class="q-btn-icon-wrap"><i class="bi bi-download"></i></div>
                            <span>Ekspor Data</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel daftar pendaftaran terbaru yang perlu dipantau. --}}
    <div class="card-custom mb-4 fade-in">
        <div class="card-header">
            <div>
                <span class="fw-700" style="font-size: 0.95rem;">Pendaftaran Terbaru</span>
                <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;">4 pendaftaran terakhir</div>
            </div>
            <a href="{{ route('admin.pendaftaran') }}" style="font-size:0.8rem; font-weight:700; color:var(--primary); text-decoration:none;">Lihat Semua <i class="bi bi-chevron-right" style="font-size:0.7rem;"></i></a>
        </div>
        <div class="table-responsive">
            <table class="table table-custom table-pendaftaran mb-0">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Level</th>
                        <th>Pelatih</th>
                        <th>Tanggal Daftar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="dash-latest-pendaftaran-tbody">
                    @if($latestPendaftarans->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="bi bi-person-x fs-2 d-block opacity-40 mb-2"></i>
                                Belum ada data pendaftaran terbaru.
                            </td>
                        </tr>
                    @else
                        {{-- Tampilkan pendaftaran terakhir dengan statusnya. --}}
                        @foreach($latestPendaftarans as $pendaftaran)
                            @php
                                $avatarChar = strtoupper(substr($pendaftaran->nama_lengkap, 0, 1));
                                $statusClass = $pendaftaran->status === 'aktif' || $pendaftaran->status === 'diterima' ? 'badge-hadir' : 'badge-izin';
                                $statusText = ucfirst($pendaftaran->status);
                            @endphp
                            <tr>
                                <td>
                                    <div class="cell-name">
                                        <div class="cell-avatar">{{ $avatarChar }}</div>
                                        <div class="cell-name-text">{{ $pendaftaran->nama_lengkap }}</div>
                                    </div>
                                </td>
                                <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">{{ explode(' (', $pendaftaran->program)[0] }}</span></td>
                                <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">{{ $pendaftaran->nama_wali ?: 'Diri Sendiri' }}</span></td>
                                <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">{{ \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->translatedFormat('d M Y') }}</span></td>
                                <td><span class="badge {{ $statusClass }} px-2.5">{{ $statusText }}</span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Script sederhana untuk mengisi sapaan dan tanggal secara dinamis. --}}
<script>
(function () {
    // Set greeting dynamically
    const hour = new Date().getHours();
    const greet = hour < 11 ? 'Selamat pagi' : hour < 15 ? 'Selamat siang' : hour < 18 ? 'Selamat sore' : 'Selamat malam';
    const greetEl = document.getElementById('welcome-greeting');
    if (greetEl) greetEl.textContent = greet + ', Admin 👏';

    // Format current date
    const dateOpts = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    const dateFormatted = new Date().toLocaleDateString('id-ID', dateOpts);
    
    const subtextEl = document.getElementById('welcome-subtext');
    if (subtextEl) subtextEl.textContent = dateFormatted + ' . Berikut ringkasan aktivitas hari ini';
})();
</script>
@endsection
