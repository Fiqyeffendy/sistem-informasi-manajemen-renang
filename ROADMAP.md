# 🗺️ ROADMAP PROYEK SIMPEL-FELLA
## Sistem Informasi Manajemen Pelatihan Les Renang Fella

> **Terakhir diperbarui:** 8 Juli 2026
> **Status Proyek:** Fase PWA & Deployment (Fase 1–4 Selesai — ±92% Proyek Selesai)

---

## 📐 Arsitektur Sistem Keseluruhan

```
┌─────────────────────────────────────────────────────────────────────────┐
│                        SIMPEL-FELLA SYSTEM                              │
│                                                                         │
│  ┌────────────────────┐           ┌─────────────────────────────────┐   │
│  │   WEB ADMIN        │           │   PWA MOBILE                    │   │
│  │   (Desktop)        │           │   (HP Pelatih & Siswa)          │   │
│  │                    │           │                                 │   │
│  │  • Dashboard       │           │  • Login                        │   │
│  │  • Data Siswa      │           │  • Dashboard Pelatih            │   │
│  │  • Data Pelatih    │           │  • Dashboard Siswa              │   │
│  │  • Jadwal          │           │  • Lihat Jadwal                 │   │
│  │  • Presensi        │           │  • Input/Lihat Presensi         │   │
│  │  • Sesi Latihan    │           │  • Sesi Latihan                 │   │
│  │  • Laporan         │           │  • Notifikasi                   │   │
│  │  • Pendaftaran     │           │                                 │   │
│  └────────┬───────────┘           └──────────────┬──────────────────┘   │
│           │                                      │                      │
│           │         Server-Side Blade + REST API  │                      │
│           │             GET / POST / DELETE        │                      │
│           └──────────────┬───────────────────────┘                      │
│                          │                                              │
│           ┌──────────────▼──────────────────┐                           │
│           │      LARAVEL BACKEND (PHP)       │                           │
│           │                                 │                           │
│           │  web.php / api.php              │                           │
│           │  Controllers ──► Models (Eloquent)                          │
│           │  Middleware Role (EnsureUserHasRole)                        │
│           │  Session Auth + CSRF protection  │                           │
│           └──────────────┬──────────────────┘                           │
│                          │                                              │
│           ┌──────────────▼──────────────────┐                           │
│           │       DATABASE (PostgreSQL)     │                           │
│           │                                 │                           │
│           │  users | siswa | pelatih         │                           │
│           │  jadwal | presensi | pendaftaran  │                           │
│           └─────────────────────────────────┘                           │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 📊 Teknologi yang Digunakan

| Komponen        | Teknologi                                    |
| :-------------- | :------------------------------------------- |
| Backend         | **PHP 8.3+** (Laravel 13 Framework)          |
| RESTful API     | Laravel API Resource Routes + Controllers    |
| Database        | PostgreSQL (dioperasikan via pgAdmin 4)      |
| Frontend Admin  | Blade Template + Tailwind CSS v4 + Vanilla JS|
| Frontend Mobile | Blade Template (siap dikonversi PWA)         |
| Auth            | Laravel Session Authentication (built-in)    |
| Middleware      | `EnsureUserHasRole` (admin/pelatih/siswa)    |
| Build Tool      | Vite                                         |
| Testing         | PHPUnit (via `php artisan test`)             |

---

## 📦 Kondisi Proyek Saat Ini (8 Juli 2026)

### ✅ Yang Sudah Selesai

#### Database & Model
| Komponen    | Migrasi | Model | Seeder | Catatan |
| :---------- | :-----: | :---: | :----: | :------ |
| Users       |   ✅    |  ✅   |   ✅   | FK `pelatih_id` & `siswa_id` string, relasi Eloquent ada |
| Siswa       |   ✅    |  ✅   |   ✅   | Custom ID `S001`, auto-generate via boot(), Observer sesi |
| Pelatih     |   ✅    |  ✅   |   ✅   | Custom ID `P001`, auto-generate via boot() |
| Jadwal      |   ✅    |  ✅   |   ✅   | FK string, relasi siswa & pelatih |
| Presensi    |   ✅    |  ✅   |   ✅   | Observer otomatis kurangi `sesi_terpakai` |
| Pendaftaran |   ✅    |  ✅   |   ✅   | Kolom `program`, `jenis_program`, `lokasi_les` |

#### PHP Enums
| Enum           | Status | Nilai |
| :------------- | :----: | :---- |
| `Program`      |   ✅   | WaterBabies, SwimStars, AquaKids, FellaSwimmer, dll. |
| `JenisProgram` |   ✅   | `Private`, `Small Group`, `Group` |
| `LokasiLes`    |   ✅   | Istana Mentari, Hotel Aston, Sekolah Cikal, dll. |

#### RESTful API (CRUD via Controller)
| Endpoint          | Index | Store | Show | Update | Destroy | Catatan |
| :---------------- | :---: | :---: | :--: | :----: | :-----: | :------ |
| `api/siswa`       |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    | Auto-ID `S001` |
| `api/pelatih`     |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    | Auto-ID `P001` |
| `api/jadwal`      |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    | Relasi siswa & pelatih |
| `api/pendaftaran` |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    | Accept → buat siswa + user otomatis |
| `api/presensi`    |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    | Terintegrasi observer sesi |

#### Halaman Web (Views Blade)
| Halaman               | Routing | Controller | Data Dinamis | UI  | Catatan |
| :-------------------- | :-----: | :--------: | :----------: | :-: | :------ |
| **Admin Dashboard**   |   ✅    |     ✅     |      ✅      | ✅  | KPI cards, chart SVG tren & sesi, list pelatih — semua real-time |
| **Admin Siswa**       |   ✅    |     ✅     |      ✅      | ✅  | Full CRUD, avatar inisial, search & filter |
| **Admin Pelatih**     |   ✅    |     ✅     |      ✅      | ✅  | Full CRUD, ID P001, badge spesialisasi |
| **Admin Jadwal**      |   ✅    |     ✅     |      ✅      | ✅  | Full CRUD, relasi siswa-pelatih |
| **Admin Pendaftaran** |   ✅    |     ✅     |      ✅      | ✅  | Wizard multi-step, accept/tolak |
| **Admin Presensi**    |   ✅    |     ✅     |      ✅      | ✅  | Riwayat kehadiran riil, search instan |
| **Admin Sesi**        |   ✅    |     ✅     |      ✅      | ✅  | Progress sesi riil (`total - terpakai`) |
| **Admin Laporan**     |   ✅    |     ✅     |      ✅      | ✅  | Filter periode, rekap per siswa |
| **Login**             |   ✅    |     ✅     |      ✅      | ✅  | Session Auth, redirect per role, cek status siswa |
| **Register**          |   ✅    |     ✅     |      ✅      | ✅  | Pemisahan tipe: wali murid vs diri sendiri |
| **Pelatih Dashboard** |   ✅    |     ✅     |      ✅      | ✅  | Jadwal hari ini, ringkasan siswa asuhan |
| **Pelatih Jadwal**    |   ✅    |     ✅     |      ✅      | ✅  | Kalender mengajar mingguan |
| **Pelatih Presensi**  |   ✅    |     ✅     |      ✅      | ✅  | Form input presensi + riwayat |
| **Pelatih Siswa**     |   ✅    |     ✅     |      ✅      | ✅  | Daftar & progress kuota siswa asuhan |
| **Siswa Dashboard**   |   ✅    |     ✅     |      ✅      | ✅  | KPI sisa sesi, jadwal terdaftar, presensi terbaru |
| **Siswa Jadwal**      |   ✅    |     ✅     |      ✅      | ✅  | Kartu jadwal per hari lengkap dengan pelatih |
| **Siswa Presensi**    |   ✅    |     ✅     |      ✅      | ✅  | Tabel riwayat kehadiran + stat hadir/izin/alpha |
| **Siswa Sesi**        |   ✅    |     ✅     |      ✅      | ✅  | Progress bar kuota, detail program & lokasi les |

> ✅ = Selesai &nbsp; 🔶 = Sebagian &nbsp; ❌ = Belum

#### Sistem Lainnya
| Komponen                  | Status | Catatan |
| :------------------------ | :----: | :------ |
| Autentikasi Backend Nyata |   ✅   | Laravel Session Auth, bukan localStorage |
| Middleware Role-based     |   ✅   | `EnsureUserHasRole` melindungi semua grup route |
| PresensiObserver          |   ✅   | Otomatis ±`sesi_terpakai` saat presensi dibuat/dihapus |
| Automated Testing         |   ✅   | 20/20 tests pass (`AdminDashboardTest`, `CoachDashboardTest`) |
| PWA (manifest + SW)       |   ❌   | Belum dibuat |
| Deployment Production     |   ❌   | Belum |

---

## 🛣️ ROADMAP PER FASE

---

### 🔵 FASE 1: Penyempurnaan Backend & API ✅ SELESAI
> **Progress: 100%**

- [x] `PresensiController.php` — full CRUD endpoint di `api/presensi`
- [x] `PresensiObserver` — otomatis kelola `sesi_terpakai` siswa
- [x] Logika laporan — filter periode, rekap status kehadiran
- [x] Semua model ID string auto-generate (`S001`, `P001`)
- [x] Enums `Program`, `JenisProgram`, `LokasiLes`
- [x] `acceptPendaftaran` — auto buat `Siswa` + `User` dari data pendaftaran

---

### 🟢 FASE 2: Penyelesaian Halaman Web Admin ✅ SELESAI
> **Progress: 100%**

- [x] Dashboard Admin — KPI dinamis + 3 chart SVG real-time (tren, sesi, pelatih)
- [x] Presensi Admin — tabel riwayat riil, hapus, search
- [x] Sesi Admin — progress bar kuota per siswa
- [x] Laporan Admin — filter periode + rekap per siswa
- [x] Semua halaman admin (Siswa, Pelatih, Jadwal, Pendaftaran) full CRUD

---

### 🟡 FASE 3: Sistem Autentikasi & Keamanan ✅ SELESAI
> **Progress: 100%**

- [x] Laravel Session Authentication (bukan localStorage)
- [x] Middleware `EnsureUserHasRole` → proteksi route admin / pelatih / siswa
- [x] Redirect otomatis ke dashboard sesuai role setelah login
- [x] Blokir login siswa dengan status `tidak_aktif` (pending verifikasi)

---

### 🟠 FASE 4: Halaman Pelatih & Siswa ✅ SELESAI
> **Progress: 100%**

- [x] **Dashboard Pelatih** — jadwal mengajar hari ini, ringkasan siswa
- [x] **Jadwal Pelatih** — kalender mengajar mingguan
- [x] **Presensi Pelatih** — form input + riwayat kehadiran siswa
- [x] **Siswa Pelatih** — daftar progress kuota siswa asuhan
- [x] **Dashboard Siswa** — sisa sesi, jadwal, log presensi terbaru
- [x] **Jadwal Siswa** — kartu jadwal per hari + info pelatih & lokasi
- [x] **Presensi Siswa** — tabel riwayat + statistik hadir/izin/alpha
- [x] **Sesi Siswa** — progress bar kuota + detail program les

---

### 🔴 FASE 5: Implementasi PWA (Progressive Web App) ❌ BELUM
> **Progress: 0%**

- [ ] Buat `public/manifest.json` (name, icons, display: standalone, theme_color)
- [ ] Daftarkan `<link rel="manifest">` di layout Blade
- [ ] Buat `public/sw.js` — cache aset statis + penanganan offline
- [ ] Daftarkan service worker di layout Blade
- [ ] Buat ikon PNG: `icon-192x192.png` dan `icon-512x512.png`
- [ ] Meta tag Apple Mobile Web App (`apple-mobile-web-app-capable`)
- [ ] Test install PWA di Chrome Android (tombol "Add to Home Screen")
- [ ] Test offline mode — halaman cache harus tetap tampil

---

### 🟣 FASE 6: Testing, Dokumentasi & Deployment ❌ BELUM
> **Progress: ~30%**

- [x] Feature Tests: `AdminDashboardTest` & `CoachDashboardTest` (20/20 pass)
- [ ] Tambah Feature Test halaman siswa (`SiswaDashboardTest`)
- [ ] Perbarui `README.md` — deskripsi, cara install, daftar endpoint API
- [ ] Pilih hosting (Railway / Render / VPS)
- [ ] Konfigurasi `.env` production (MySQL, APP_URL)
- [ ] `php artisan migrate --seed` di server production
- [ ] `npm run build` — compile aset frontend untuk produksi
- [ ] Pastikan URL production dapat diakses publik (demo PWA ke dosen)

---

## 📅 Ringkasan Progress

| Fase | Deskripsi                          | Progress    |
| :--- | :--------------------------------- | :---------- |
| 1    | Backend & API                      | **100% ✅** |
| 2    | Halaman Web Admin                  | **100% ✅** |
| 3    | Autentikasi & Keamanan             | **100% ✅** |
| 4    | Halaman Pelatih & Siswa            | **100% ✅** |
| 5    | PWA                                | **0% ❌**   |
| 6    | Testing, Dokumentasi & Deployment  | **30% 🔶**  |

> **Yang perlu dikerjakan selanjutnya:** Fase 5 (PWA) → Fase 6 (Deployment). Estimasi: **2–4 hari lagi**.
