@extends('layouts.app')

@section('content')
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

    <!-- Header Section -->
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

    <!-- 4 KPI Cards -->
    <div class="stat-grid">
        <!-- Card 1 -->
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon siswa-icon"><i class="bi bi-people"></i></div>
                <span class="badge badge-success" style="font-size:0.68rem; padding:0.25rem 0.5rem;">+ 12% bulan ini</span>
            </div>
            <div class="stat-box-value" id="stat-siswa-val">47</div>
            <p class="stat-box-label">Total Siswa Aktif</p>
        </div>
        <!-- Card 2 -->
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon kelas-icon"><i class="bi bi-calendar-check"></i></div>
                <span class="badge badge-success" style="font-size:0.68rem; padding:0.25rem 0.5rem;">+ 1 kelas baru</span>
            </div>
            <div class="stat-box-value" id="stat-kelas-val">5</div>
            <p class="stat-box-label">Kelas Berjalan</p>
        </div>
        <!-- Card 3 -->
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon pelatih-icon"><i class="bi bi-person-badge"></i></div>
                <span class="badge badge-success" style="font-size:0.68rem; padding:0.25rem 0.5rem;">+ sama</span>
            </div>
            <div class="stat-box-value" id="stat-pelatih-val">4</div>
            <p class="stat-box-label">Pelatih Aktif</p>
        </div>
        <!-- Card 4 -->
        <div class="stat-box">
            <div class="stat-box-top">
                <div class="stat-box-icon hadir-icon"><i class="bi bi-clipboard2-check"></i></div>
                <span class="badge badge-alpha" style="font-size:0.68rem; padding:0.25rem 0.5rem;">↓ 3 absen</span>
            </div>
            <div class="stat-box-value" id="stat-kehadiran-val">23</div>
            <p class="stat-box-label">Kehadiran Hari Ini</p>
        </div>
    </div>

    <!-- Row 2: Jadwal Hari Ini & Tren Kehadiran -->
    <div class="row g-3 mb-4">
        <!-- Left: Jadwal Hari Ini -->
        <div class="col-lg-6">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Jadwal Hari Ini</span>
                        <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;" id="dash-date-sub">Sabtu, 29 Juni 2024</div>
                    </div>
                    <span class="badge badge-info" id="dash-total-sesi-badge">5 Sesi</span>
                </div>
                <div class="card-body">
                    <div class="sched-list" id="dash-sched-container">
                        <!-- Sesi 1 -->
                        <div class="sched-box">
                            <div class="sched-time-col">06:00</div>
                            <div class="sched-info-col">
                                <div class="sched-title">Advanced Morning</div>
                                <div class="sched-sub">Coach Rini . Pool A</div>
                            </div>
                            <div class="sched-badge-col">
                                <span class="label-siswa">4 siswa</span>
                            </div>
                        </div>
                        <!-- Sesi 2 -->
                        <div class="sched-box">
                            <div class="sched-time-col">07:00</div>
                            <div class="sched-info-col">
                                <div class="sched-title">Beginner Morning A</div>
                                <div class="sched-sub">Coach Budi . Pool A</div>
                            </div>
                            <div class="sched-badge-col">
                                <span class="label-siswa">6 siswa</span>
                            </div>
                        </div>
                        <!-- Sesi 3 (Active Highlighted) -->
                        <div class="sched-box active">
                            <div class="sched-time-col" style="color:var(--success);">09:00</div>
                            <div class="sched-info-col">
                                <div class="sched-title" style="color:#14532d;">Junior Saturday</div>
                                <div class="sched-sub" style="color:#166534;">Coach Budi . Pool B</div>
                            </div>
                            <div class="sched-badge-col">
                                <span class="label-siswa" style="color:#166534; display:block; margin-bottom: 2px;">7 siswa</span>
                                <span class="badge badge-hadir" style="padding:0.2rem 0.5rem; font-size:0.65rem;">Berlangsung</span>
                            </div>
                        </div>
                        <!-- Sesi 4 -->
                        <div class="sched-box">
                            <div class="sched-time-col">15:00</div>
                            <div class="sched-info-col">
                                <div class="sched-title">Intermediate Afternoon</div>
                                <div class="sched-sub">Coach Ani . Pool B</div>
                            </div>
                            <div class="sched-badge-col">
                                <span class="label-siswa">5 siswa</span>
                            </div>
                        </div>
                        <!-- Sesi 5 -->
                        <div class="sched-box">
                            <div class="sched-time-col">17:00</div>
                            <div class="sched-info-col">
                                <div class="sched-title">Beginner Evening B</div>
                                <div class="sched-sub">Coach Dian . Pool C</div>
                            </div>
                            <div class="sched-badge-col">
                                <span class="label-siswa">3 siswa</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Tren Kehadiran -->
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
                            
                            <!-- Filled Area path -->
                            <path d="M 40 100 Q 100 80 160 90 T 280 85 T 400 70 T 480 75 L 480 160 L 40 160 Z" fill="url(#chart-fill-grad)" />

                            <!-- Curve Line -->
                            <path d="M 40 100 Q 100 80 160 90 T 280 85 T 400 70 T 480 75" fill="none" stroke="#2563eb" stroke-width="3" stroke-linecap="round" />

                            <!-- Interactive Dots -->
                            <circle cx="400" cy="70" r="4.5" fill="#fff" stroke="#2563eb" stroke-width="2.5" />
                            <circle cx="480" cy="75" r="4.5" fill="#fff" stroke="#2563eb" stroke-width="2.5" />
                        </svg>
                    </div>
                    <!-- X labels -->
                    <div class="d-flex justify-content-between px-4 pt-2 text-muted fw-600" style="font-size: 0.72rem; letter-spacing: 0.2px;">
                        <span>W1 May</span>
                        <span>W2 May</span>
                        <span>W3 May</span>
                        <span>W4 May</span>
                        <span>W1 Jun</span>
                        <span>W2 Jun</span>
                        <span>W3 Jun</span>
                        <span>W4 Jun</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Status Pelatih, Sesi per Hari & Aksi Cepat -->
    <div class="row g-3 mb-4">
        <!-- Status Pelatih -->
        <div class="col-lg-4">
            <div class="card-custom h-100">
                <div class="card-header">
                    <div>
                        <span class="fw-700" style="font-size: 0.95rem;">Status Pelatih</span>
                        <div class="text-muted" style="font-size: 0.77rem; font-weight: 500; margin-top: 0.125rem;">Ketersediaan hari ini</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="coach-row">
                        <div class="coach-left-info">
                            <div class="coach-initials-avatar">BH</div>
                            <div>
                                <span class="coach-name">Budi Hartono</span>
                                <span class="coach-subtext">12 siswa . 24 sesi</span>
                            </div>
                        </div>
                        <span class="badge badge-hadir" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Available</span>
                    </div>
                    <div class="coach-row">
                        <div class="coach-left-info">
                            <div class="coach-initials-avatar">AS</div>
                            <div>
                                <span class="coach-name">Ani Susanti</span>
                                <span class="coach-subtext">9 siswa . 18 sesi</span>
                            </div>
                        </div>
                        <span class="badge badge-hadir" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Available</span>
                    </div>
                    <div class="coach-row">
                        <div class="coach-left-info">
                            <div class="coach-initials-avatar">RW</div>
                            <div>
                                <span class="coach-name">Rini Wulandari</span>
                                <span class="coach-subtext">7 siswa . 14 sesi</span>
                            </div>
                        </div>
                        <span class="badge badge-izin" style="font-size:0.68rem; padding:0.25rem 0.5rem;">Busy</span>
                    </div>
                    <div class="coach-row">
                        <div class="coach-left-info">
                            <div class="coach-initials-avatar">DP</div>
                            <div>
                                <span class="coach-name">Dian Pratomo</span>
                                <span class="coach-subtext">5 siswa . 10 sesi</span>
                            </div>
                        </div>
                        <span class="badge badge-info" style="font-size:0.68rem; padding:0.25rem 0.5rem; background:#f1f5f9; color:#475569; border-color:#e2e8f0;">On Leave</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sesi per Hari Chart -->
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
                            <!-- Mon (value 6 -> height 90) -->
                            <rect x="40" y="50" width="14" height="60" rx="4" fill="#2563eb" />
                            <!-- Tue (value 4 -> height 60) -->
                            <rect x="78" y="70" width="14" height="40" rx="4" fill="#2563eb" />
                            <!-- Wed (value 6.5 -> height 97) -->
                            <rect x="116" y="42" width="14" height="68" rx="4" fill="#2563eb" />
                            <!-- Thu (value 5 -> height 75) -->
                            <rect x="154" y="60" width="14" height="50" rx="4" fill="#2563eb" />
                            <!-- Fri (value 6 -> height 90) -->
                            <rect x="192" y="50" width="14" height="60" rx="4" fill="#2563eb" />
                            <!-- Sat (value 8 -> height 120) -->
                            <rect x="230" y="20" width="14" height="90" rx="4" fill="#2563eb" />
                            <!-- Sun (value 2.5 -> height 37) -->
                            <rect x="268" y="92" width="14" height="18" rx="4" fill="#2563eb" />
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

        <!-- Aksi Cepat -->
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

    <!-- Row 4: Pendaftaran Terbaru Table -->
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
                    <!-- Row 1 -->
                    <tr>
                        <td>
                            <div class="cell-name">
                                <div class="cell-avatar">F</div>
                                <div class="cell-name-text">Fajar Nugroho</div>
                            </div>
                        </td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Beginner</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Budi Hartono</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">01 Apr 2024</span></td>
                        <td><span class="badge badge-hadir px-2.5">Active</span></td>
                    </tr>
                    <!-- Row 2 -->
                    <tr>
                        <td>
                            <div class="cell-name">
                                <div class="cell-avatar">A</div>
                                <div class="cell-name-text">Ahmad Fauzi</div>
                            </div>
                        </td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Intermediate</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Ani Susanti</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">01 Mar 2024</span></td>
                        <td><span class="badge badge-hadir px-2.5">Active</span></td>
                    </tr>
                    <!-- Row 3 -->
                    <tr>
                        <td>
                            <div class="cell-name">
                                <div class="cell-avatar">N</div>
                                <div class="cell-name-text">Nur Aini</div>
                            </div>
                        </td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Intermediate</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Rini Wulandari</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">14 Feb 2024</span></td>
                        <td><span class="badge badge-hadir px-2.5">Active</span></td>
                    </tr>
                    <!-- Row 4 -->
                    <tr>
                        <td>
                            <div class="cell-name">
                                <div class="cell-avatar">S</div>
                                <div class="cell-name-text">Siti Rahayu</div>
                            </div>
                        </td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Intermediate</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">Ani Susanti</span></td>
                        <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">03 Feb 2024</span></td>
                        <td><span class="badge badge-hadir px-2.5">Active</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

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

    const dateSubEl = document.getElementById('dash-date-sub');
    if (dateSubEl) dateSubEl.textContent = dateFormatted;

    // Async Fetch dynamic stats from database to populate KPI metrics
    async function loadDashStats() {
        try {
            const [siswaRes, pelatihRes, jadwalRes, presensiRes, pendaftaranRes] = await Promise.all([
                fetch('/api/siswa'),
                fetch('/api/pelatih'),
                fetch('/api/jadwal'),
                fetch('/api/presensi'),
                fetch('/api/pendaftaran')
            ]);

            if (siswaRes.ok) {
                const data = await siswaRes.json();
                const count = Array.isArray(data) ? data.length : 0;
                const el = document.getElementById('stat-siswa-val');
                if (el && count > 0) el.textContent = count;
            }

            if (pelatihRes.ok) {
                const data = await pelatihRes.json();
                const count = Array.isArray(data) ? data.length : 0;
                const el = document.getElementById('stat-pelatih-val');
                if (el && count > 0) el.textContent = count;
            }

            if (jadwalRes.ok) {
                const data = await jadwalRes.json();
                const count = Array.isArray(data) ? data.length : 0;
                
                // filter active classes
                const activeCount = Array.isArray(data) ? data.filter(j => j.status === 'aktif' || j.status === 'Aktif').length : 0;
                const elKelas = document.getElementById('stat-kelas-val');
                if (elKelas && activeCount > 0) elKelas.textContent = activeCount;

                const elTotalSesi = document.getElementById('dash-total-sesi-badge');
                if (elTotalSesi && count > 0) elTotalSesi.textContent = `${count} Sesi`;
            }

            // Fill pendaftaran table if API responds
            if (pendaftaranRes.ok) {
                const data = await pendaftaranRes.json();
                const items = Array.isArray(data) ? data.slice(0, 4) : [];
                if (items.length > 0) {
                    const tbody = document.getElementById('dash-latest-pendaftaran-tbody');
                    tbody.innerHTML = items.map(item => {
                        const avatarChar = item.nama_lengkap ? item.nama_lengkap.charAt(0).toUpperCase() : 'S';
                        const statusClass = item.status === 'aktif' || item.status === 'Active' || item.status === 'diterima' ? 'badge-hadir' : 'badge-izin';
                        const statusText = item.status ? (item.status.charAt(0).toUpperCase() + item.status.slice(1)) : 'Active';
                        
                        // Parse date
                        let regDateStr = 'Baru';
                        if (item.created_at) {
                            try {
                                const d = new Date(item.created_at);
                                regDateStr = d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
                            } catch(e) {}
                        }

                        return `
                            <tr>
                                <td>
                                    <div class="cell-name">
                                        <div class="cell-avatar">${avatarChar}</div>
                                        <div class="cell-name-text">${item.nama_lengkap || 'Siswa'}</div>
                                    </div>
                                </td>
                                <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">${item.program || 'Beginner'}</span></td>
                                <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">${item.nama_orang_tua || 'Budi Hartono'}</span></td>
                                <td><span style="font-weight: 500; font-size: 0.855rem; color: var(--text-secondary);">${regDateStr}</span></td>
                                <td><span class="badge ${statusClass} px-2.5">${statusText}</span></td>
                            </tr>
                        `;
                    }).join('');
                }
            }

        } catch (e) {
            console.error('Failed to load dynamic stats', e);
        }
    }

    loadDashStats();
})();
</script>
@endsection
