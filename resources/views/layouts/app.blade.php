{{-- Layout utama aplikasi yang menyusun sidebar, topbar, dan konten halaman. --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SIMPEL-Fella</title>
    <meta name="description" content="Sistem Informasi Manajemen Pelatihan Les Renang Fella" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/variables.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/shell.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />
</head>
<body>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div id="app-shell" class="active" style="display:flex;">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-brand">
                <div class="sidebar-brand-inner">
                    <div class="brand-logo"><i class="bi bi-water"></i></div>
                    <div class="brand-text-wrap">
                        <span class="brand-name">SIMPEL-Fella</span>
                        <span class="brand-sub">Manajemen Kursus Renang</span>
                    </div>
                </div>
            </div>

            <nav class="sidebar-nav" id="nav-admin" style="display: {{ request()->routeIs('admin.*') ? 'block' : 'none' }};">
                <div class="nav-section-label">MENU UTAMA</div>
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-grid"></i> Dashboard</a>
                <a class="nav-link {{ request()->routeIs('admin.siswa') ? 'active' : '' }}" href="{{ route('admin.siswa') }}"><i class="bi bi-people"></i> Siswa</a>
                <a class="nav-link {{ request()->routeIs('admin.pendaftaran') ? 'active' : '' }}" href="{{ route('admin.pendaftaran') }}"><i class="bi bi-person-plus"></i> Pendaftaran</a>
                <a class="nav-link {{ request()->routeIs('admin.pelatih') ? 'active' : '' }}" href="{{ route('admin.pelatih') }}"><i class="bi bi-person-badge"></i> Pelatih</a>
                <a class="nav-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }}" href="{{ route('admin.jadwal') }}"><i class="bi bi-calendar3"></i> Jadwal</a>
                <a class="nav-link {{ request()->routeIs('admin.presensi') ? 'active' : '' }}" href="{{ route('admin.presensi') }}"><i class="bi bi-clipboard-check"></i> Kehadiran</a>
                <a class="nav-link {{ request()->routeIs('admin.sesi') ? 'active' : '' }}" href="{{ route('admin.sesi') }}"><i class="bi bi-hourglass-split"></i> Sisa Sesi</a>
                <a class="nav-link {{ request()->routeIs('admin.laporan') ? 'active' : '' }}" href="{{ route('admin.laporan') }}"><i class="bi bi-bar-chart-line"></i> Laporan</a>
            </nav>

            <nav class="sidebar-nav" id="nav-pelatih" style="display: {{ request()->routeIs('pelatih.*') ? 'block' : 'none' }};">
                <div class="nav-section-label">MENU UTAMA</div>
                <a class="nav-link {{ request()->routeIs('pelatih.dashboard') ? 'active' : '' }}" href="{{ route('pelatih.dashboard') }}"><i class="bi bi-grid"></i> Dashboard</a>
                <a class="nav-link {{ request()->routeIs('pelatih.jadwal') ? 'active' : '' }}" href="{{ route('pelatih.jadwal') }}"><i class="bi bi-calendar3"></i> Jadwal Saya</a>
                <a class="nav-link {{ request()->routeIs('pelatih.siswa') ? 'active' : '' }}" href="{{ route('pelatih.siswa') }}"><i class="bi bi-people"></i> Daftar Siswa</a>
                <a class="nav-link {{ request()->routeIs('pelatih.presensi') ? 'active' : '' }}" href="{{ route('pelatih.presensi') }}"><i class="bi bi-clipboard-check"></i> Input Presensi</a>
            </nav>

            <nav class="sidebar-nav" id="nav-siswa" style="display: {{ request()->routeIs('siswa.*') ? 'block' : 'none' }};">
                <div class="nav-section-label">MENU UTAMA</div>
                <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}" href="{{ route('siswa.dashboard') }}"><i class="bi bi-house"></i> Beranda</a>
                <a class="nav-link {{ request()->routeIs('siswa.jadwal') ? 'active' : '' }}" href="{{ route('siswa.jadwal') }}"><i class="bi bi-calendar3"></i> Jadwal Latihan</a>
                <a class="nav-link {{ request()->routeIs('siswa.presensi') ? 'active' : '' }}" href="{{ route('siswa.presensi') }}"><i class="bi bi-clock-history"></i> Riwayat Presensi</a>
                <a class="nav-link {{ request()->routeIs('siswa.sesi') ? 'active' : '' }}" href="{{ route('siswa.sesi') }}"><i class="bi bi-hourglass-split"></i> Sisa Sesi</a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-chip">
                    @php
                        $user = Auth::user();
                        $name = $user?->name ?? 'User';
                        $email = $user?->email ?? '';
                        $initials = '';
                        if ($name) {
                            $words = explode(' ', trim($name));
                            $initials = strtoupper(substr($words[0], 0, 1));
                            if (count($words) > 1) {
                                $initials .= strtoupper(substr($words[1], 0, 1));
                            }
                        }
                    @endphp
                    <div class="user-avatar" id="user-avatar-text" style="background: var(--primary);">{{ $initials }}</div>
                    <div class="info flex-grow-1">
                        <span id="sidebar-user-name" style="font-weight:600; color:var(--text-main);">{{ $name }}</span>
                        <small id="sidebar-user-role" style="color:var(--text-secondary);">{{ $email }}</small>
                    </div>
                </div>
                <div style="padding: 0.25rem 0.5rem;">
                    <form method="POST" action="{{ route('auth.logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="nav-link" style="display:flex; align-items:center; gap:0.625rem; padding:0.5rem 0.875rem; color:var(--text-secondary); text-decoration:none; font-size:0.855rem; font-weight:500; border:none; background:none; width:100%; text-align:left; cursor:pointer;">
                            <i class="bi bi-box-arrow-left"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <button class="btn-hamburger" id="btn-toggle-sidebar"><i class="bi bi-list"></i></button>
                    <h5 id="topbar-title">
                        @if(request()->routeIs('*.dashboard')) Dashboard
                        @elseif(request()->routeIs('*.siswa')) Daftar Siswa
                        @elseif(request()->routeIs('*.pendaftaran')) Pendaftaran
                        @elseif(request()->routeIs('*.pelatih')) Pelatih
                        @elseif(request()->routeIs('*.jadwal')) Jadwal Mengajar
                        @elseif(request()->routeIs('*.presensi')) Presensi Kehadiran
                        @elseif(request()->routeIs('*.sesi')) Sisa Sesi
                        @elseif(request()->routeIs('*.laporan')) Laporan
                        @else SIMPEL-Fella
                        @endif
                    </h5>
                </div>
                <div class="right">
                    <div class="search-input-wrap d-none d-md-block">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Cari...">
                    </div>
                    <button class="topbar-icon-btn position-relative" title="Notifikasi" style="background:#fff; border:1px solid var(--border); border-radius:9px; width:34px; height:34px; display:flex; align-items:center; justify-content:center;">
                        <i class="bi bi-bell"></i>
                        <span class="position-absolute bg-primary border border-light rounded-circle" style="width:6px; height:6px; top:8px; right:8px;"></span>
                    </button>
                </div>
            </div>

            <div class="page-body">
                @yield('content')
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-tambah-siswa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Tambah Siswa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label small fw-600">Nama Siswa</label><input id="siswa-nama" class="form-control" placeholder="Nama lengkap"></div>
                    <div class="mb-3"><label class="form-label small fw-600">Paket</label><input id="siswa-paket" class="form-control" value="Bronze" placeholder="Bronze"></div>
                    <div class="mb-3"><label class="form-label small fw-600">Program</label><select id="siswa-program" class="form-select"><option value="Fella WaterBabies (Swimming Lessons for Toddlers)">Fella WaterBabies (Swimming Lessons for Toddlers)</option><option value="Fella SwimStars (Swimming Lessons for Kids)">Fella SwimStars (Swimming Lessons for Kids)</option><option value="Fella AquaFit (Swimming Lessons for Adults)">Fella AquaFit (Swimming Lessons for Adults)</option><option value="Fella SwimElite (Swimming Lessons for Elite)">Fella SwimElite (Swimming Lessons for Elite)</option></select></div>
                    <div class="row g-2 mb-3"><div class="col"><label class="form-label small fw-600">Umur</label><input id="siswa-umur" class="form-control" type="number" placeholder="10"></div><div class="col"><label class="form-label small fw-600">Jenis Program</label><select id="siswa-jenis-program" class="form-select"><option value="Small Group">Small Group</option><option value="Group">Group</option><option value="Semi-private">Semi-private</option><option value="Private">Private</option></select></div></div>
                    <div class="mb-3"><label class="form-label small fw-600">Lokasi Les</label><select id="siswa-lokasi-les" class="form-select"><option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option><option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option><option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option><option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option><option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option><option value="Regency 21">Regency 21</option><option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option><option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option><option value="Legok Asri Park">Legok Asri Park</option></select></div>
                    <div class="mb-3"><label class="form-label small fw-600">Total Sesi</label><input id="siswa-total-sesi" class="form-control" type="number" placeholder="4" value="4"></div>
                    <div class="mb-3"><label class="form-label small fw-600">No. HP Orang Tua</label><input id="siswa-no-hp" class="form-control" placeholder="0812-xxxx-xxxx"></div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-siswa" data-bs-dismiss="modal"><i class="bi bi-save me-1"></i>Simpan</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit-siswa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Siswa</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body"><div class="mb-3"><label class="form-label small fw-600">Nama Siswa</label><input id="siswa-edit-nama" class="form-control" value="Ahmad Fauzi"></div><div class="mb-3"><label class="form-label small fw-600">Program</label><select id="siswa-edit-program" class="form-select"><option value="Fella WaterBabies (Swimming Lessons for Toddlers)">Fella WaterBabies (Swimming Lessons for Toddlers)</option><option value="Fella SwimStars (Swimming Lessons for Kids)">Fella SwimStars (Swimming Lessons for Kids)</option><option value="Fella AquaFit (Swimming Lessons for Adults)">Fella AquaFit (Swimming Lessons for Adults)</option><option value="Fella SwimElite (Swimming Lessons for Elite)">Fella SwimElite (Swimming Lessons for Elite)</option></select></div><div class="row g-2 mb-3"><div class="col"><label class="form-label small fw-600">Umur</label><input id="siswa-edit-umur" class="form-control" type="number" value="10"></div><div class="col"><label class="form-label small fw-600">Jenis Program</label><select id="siswa-edit-jenis-program" class="form-select"><option value="Small Group">Small Group</option><option value="Group">Group</option><option value="Semi-private">Semi-private</option><option value="Private">Private</option></select></div></div><div class="mb-3"><label class="form-label small fw-600">Lokasi Les</label><select id="siswa-edit-lokasi-les" class="form-select"><option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option><option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option><option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option><option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option><option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option><option value="Regency 21">Regency 21</option><option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option><option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option><option value="Legok Asri Park">Legok Asri Park</option></select></div><div class="mb-3"><label class="form-label small fw-600">Total Sesi</label><input id="siswa-edit-total-sesi" class="form-control" type="number" value="4"></div><div class="mb-2"><label class="form-label small fw-600">No. HP Orang Tua</label><input id="siswa-edit-no-hp" class="form-control" value="0812-3456-7890"></div></div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-edit-siswa"><i class="bi bi-save me-1"></i>Update</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-tambah-pelatih" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title"><i class="bi bi-person-badge me-2"></i>Tambah Pelatih</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label small fw-600">Nama Pelatih</label><input id="pelatih-nama" class="form-control" placeholder="Nama lengkap"></div>
                    <div class="mb-3"><label class="form-label small fw-600">No. HP</label><input id="pelatih-no-hp" class="form-control" placeholder="0812-xxxx-xxxx"></div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Spesialisasi</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['Toddler', 'Kids', 'Adults', 'Spesial'] as $spesial)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="pelatih-spesialisasi[]" id="spesial-add-{{ strtolower($spesial) }}" value="{{ $spesial }}">
                                    <label class="form-check-label small" for="spesial-add-{{ strtolower($spesial) }}">{{ $spesial }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Jadwal Mengajar</label>
                        <div class="d-flex flex-column gap-2" id="jadwal-add-wrapper">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check mb-0" style="min-width: 90px;">
                                        <input class="form-check-input jadwal-hari-cb" type="checkbox"
                                               name="jadwal-add-hari[]"
                                               id="jadwal-add-{{ strtolower($hari) }}"
                                               value="{{ $hari }}"
                                               onchange="toggleJamInput('add', '{{ strtolower($hari) }}', this.checked)">
                                        <label class="form-check-label small" for="jadwal-add-{{ strtolower($hari) }}">{{ $hari }}</label>
                                    </div>
                                    <input type="time" class="form-control form-control-sm"
                                           id="jadwal-add-jam-{{ strtolower($hari) }}"
                                           name="jadwal-add-jam[{{ strtolower($hari) }}]"
                                           value="07:00"
                                           disabled
                                           style="max-width: 130px;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Status</label>
                        <select id="pelatih-status" class="form-select" onchange="toggleAlasanCuti('add')">
                            <option value="aktif">Aktif</option>
                            <option value="cuti">Cuti</option>
                        </select>
                    </div>
                    <div class="mb-3" id="pelatih-alasan-cuti-wrapper" style="display: none;">
                        <label class="form-label small fw-600 text-danger">Alasan Cuti</label>
                        <textarea id="pelatih-alasan-cuti" class="form-control" rows="2" placeholder="Tulis alasan cuti pelatih..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-pelatih" data-bs-dismiss="modal"><i class="bi bi-save me-1"></i>Simpan</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit-pelatih" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Pelatih</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label small fw-600">Nama Pelatih</label><input id="pelatih-edit-nama" class="form-control" placeholder="Nama lengkap"></div>
                    <div class="mb-3"><label class="form-label small fw-600">No. HP</label><input id="pelatih-edit-no-hp" class="form-control" placeholder="0812-xxxx-xxxx"></div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Spesialisasi</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(['Toddler', 'Kids', 'Adults', 'Spesial'] as $spesial)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="pelatih-edit-spesialisasi[]" id="spesial-edit-{{ strtolower($spesial) }}" value="{{ $spesial }}">
                                    <label class="form-check-label small" for="spesial-edit-{{ strtolower($spesial) }}">{{ $spesial }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Jadwal Mengajar</label>
                        <div class="d-flex flex-column gap-2" id="jadwal-edit-wrapper">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $hari)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="form-check mb-0" style="min-width: 90px;">
                                        <input class="form-check-input jadwal-hari-cb" type="checkbox"
                                               name="jadwal-edit-hari[]"
                                               id="jadwal-edit-{{ strtolower($hari) }}"
                                               value="{{ $hari }}"
                                               onchange="toggleJamInput('edit', '{{ strtolower($hari) }}', this.checked)">
                                        <label class="form-check-label small" for="jadwal-edit-{{ strtolower($hari) }}">{{ $hari }}</label>
                                    </div>
                                    <input type="time" class="form-control form-control-sm"
                                           id="jadwal-edit-jam-{{ strtolower($hari) }}"
                                           name="jadwal-edit-jam[{{ strtolower($hari) }}]"
                                           value="07:00"
                                           disabled
                                           style="max-width: 130px;">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Status</label>
                        <select id="pelatih-edit-status" class="form-select" onchange="toggleAlasanCuti('edit')">
                            <option value="aktif">Aktif</option>
                            <option value="cuti">Cuti</option>
                        </select>
                    </div>
                    <div class="mb-3" id="pelatih-edit-alasan-cuti-wrapper" style="display: none;">
                        <label class="form-label small fw-600 text-danger">Alasan Cuti</label>
                        <textarea id="pelatih-edit-alasan-cuti" class="form-control" rows="2" placeholder="Tulis alasan cuti pelatih..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-edit-pelatih"><i class="bi bi-save me-1"></i>Update</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-tambah-jadwal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title"><i class="bi bi-calendar-plus me-2"></i>Tambah Jadwal</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label small fw-600">Siswa</label><select id="jadwal-siswa" class="form-select"><option value="">Pilih Siswa</option></select></div>
                    <div class="mb-3"><label class="form-label small fw-600">Pelatih</label><select id="jadwal-pelatih" class="form-select"><option value="">Pilih Pelatih</option></select></div>
                    <div class="row g-2 mb-3">
                        <div class="col"><label class="form-label small fw-600">Hari</label><select id="jadwal-hari" class="form-select"><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select></div>
                        <div class="col"><label class="form-label small fw-600">Jam</label><input id="jadwal-jam" class="form-control" type="time" value="07:00"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Lokasi Les</label>
                        <select id="jadwal-lokasi" class="form-select">
                            <option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option>
                            <option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option>
                            <option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option>
                            <option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option>
                            <option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option>
                            <option value="Regency 21">Regency 21</option>
                            <option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option>
                            <option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option>
                            <option value="Legok Asri Park">Legok Asri Park</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Durasi Latihan</label>
                        <select id="jadwal-durasi" class="form-select">
                            <option value="30 Menit">30 Menit</option>
                            <option value="60 Menit" selected>60 Menit</option>
                            <option value="90 Menit">90 Menit</option>
                            <option value="120 Menit">120 Menit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Tipe Jadwal</label>
                        <select id="jadwal-tipe" class="form-select">
                            <option value="reguler">Reguler</option>
                            <option value="backup">Backup</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-jadwal" data-bs-dismiss="modal"><i class="bi bi-save me-1"></i>Simpan</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit-jadwal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Jadwal</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label class="form-label small fw-600">Siswa</label><select id="jadwal-edit-siswa" class="form-select"></select></div>
                    <div class="mb-3"><label class="form-label small fw-600">Pelatih</label><select id="jadwal-edit-pelatih" class="form-select"></select></div>
                    <div class="row g-2 mb-3">
                        <div class="col"><label class="form-label small fw-600">Hari</label><select id="jadwal-edit-hari" class="form-select"><option>Senin</option><option>Selasa</option><option>Rabu</option><option>Kamis</option><option>Jumat</option><option>Sabtu</option><option>Minggu</option></select></div>
                        <div class="col"><label class="form-label small fw-600">Jam</label><input id="jadwal-edit-jam" class="form-control" type="time"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Lokasi Les</label>
                        <select id="jadwal-edit-lokasi" class="form-select">
                            <option value="Perumahan Istana Mentari">Perumahan Istana Mentari</option>
                            <option value="Hotel Aston Sidoarjo">Hotel Aston Sidoarjo</option>
                            <option value="Hotel Swiss Berlinn">Hotel Swiss Berlinn</option>
                            <option value="Hotel Sofia Juanda">Hotel Sofia Juanda</option>
                            <option value="Permata Waterpark Tanggulangin">Permata Waterpark Tanggulangin</option>
                            <option value="Regency 21">Regency 21</option>
                            <option value="Premier Place Hotel Juanda">Premier Place Hotel Juanda</option>
                            <option value="Apartment Prospero Sidoarjo">Apartment Prospero Sidoarjo</option>
                            <option value="Legok Asri Park">Legok Asri Park</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Durasi Latihan</label>
                        <select id="jadwal-edit-durasi" class="form-select">
                            <option value="30 Menit">30 Menit</option>
                            <option value="60 Menit">60 Menit</option>
                            <option value="90 Menit">90 Menit</option>
                            <option value="120 Menit">120 Menit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-600">Tipe Jadwal</label>
                        <select id="jadwal-edit-tipe" class="form-select">
                            <option value="reguler">Reguler</option>
                            <option value="backup">Backup</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label small fw-600">Status</label>
                        <select id="jadwal-edit-status" class="form-select">
                            <option value="aktif">Aktif</option>
                            <option value="tidak_aktif">Tidak Aktif</option>
                            <option value="libur">Libur</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-light" data-bs-dismiss="modal">Batal</button><button class="btn btn-primary" data-action="save-edit-jadwal" data-bs-dismiss="modal"><i class="bi bi-save me-1"></i>Update</button></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-hapus" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm"><div class="modal-content"><div class="modal-header" style="background:linear-gradient(90deg,#c62828,#e53935);"><h5 class="modal-title text-white"><i class="bi bi-trash me-2"></i>Hapus Data</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body text-center py-4"><i class="bi bi-exclamation-triangle-fill text-danger fs-1 mb-3 d-block"></i><p class="mb-0" data-hapus-message="1">Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p></div><div class="modal-footer border-0 justify-content-center"><button class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button><button class="btn btn-danger px-4" data-action="do-hapus" data-bs-dismiss="modal">Hapus</button></div></div></div>
    </div>

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
        <div id="toast-msg" class="toast align-items-center text-white border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-600" id="toast-text">Berhasil!</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
</body>
</html>
