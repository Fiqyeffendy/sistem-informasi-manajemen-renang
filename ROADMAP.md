# 🗺️ ROADMAP PROYEK SIMPEL-FELLA
## Sistem Informasi Manajemen Pelatihan Les Renang Fella

> **Terakhir diperbarui:** 6 Juli 2026
> **Status Proyek:** Fase Pengembangan Aktif (±50% Web Admin selesai)

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
│           │      RESTful API (JSON via HTTP)      │                      │
│           │         GET / POST / PUT / DELETE     │                      │
│           └──────────────┬───────────────────────┘                      │
│                          │                                              │
│           ┌──────────────▼──────────────────┐                           │
│           │      LARAVEL BACKEND (PHP)      │                           │
│           │                                 │                           │
│           │  Routes ──► Controllers ──► Models                          │
│           │  (api.php)  (Api/*.php)    (Eloquent)                       │
│           │                                 │                           │
│           │  • Autentikasi (Sanctum Token)   │                           │
│           │  • Validasi Input                │                           │
│           │  • Logika Bisnis                 │                           │
│           │  • Middleware Role               │                           │
│           └──────────────┬──────────────────┘                           │
│                          │                                              │
│           ┌──────────────▼──────────────────┐                           │
│           │       DATABASE (MySQL/SQLite)    │                           │
│           │                                 │                           │
│           │  users | siswa | pelatih         │                           │
│           │  jadwal | presensi | pendaftaran  │                           │
│           └─────────────────────────────────┘                           │
└─────────────────────────────────────────────────────────────────────────┘
```

---

## 📊 Teknologi yang Digunakan

| Komponen        | Teknologi                                 |
| :-------------- | :---------------------------------------- |
| Backend         | **PHP** (Laravel Framework)               |
| RESTful API     | Laravel API Resource Routes + Controllers |
| Database        | SQLite (dev) / MySQL (production)         |
| Frontend Admin  | Blade Template + Bootstrap 5 + Vanilla JS |
| Frontend Mobile | PWA (Progressive Web App)                 |
| Auth            | Laravel Sanctum (Token-based)             |
| Build Tool      | Vite                                      |

---

## 📦 Kondisi Proyek Saat Ini (6 Juli 2026)

### ✅ Yang Sudah Selesai

#### Database & Model
| Komponen    | Migrasi | Model | Seeder |
| :---------- | :-----: | :---: | :----: |
| Users       |   ✅    |  ✅   |   ✅   |
| Siswa       |   ✅    |  ✅   |   ✅   |
| Pelatih     |   ✅    |  ✅   |   ✅   |
| Jadwal      |   ✅    |  ✅   |   ✅   |
| Presensi    |   ✅    |  ✅   |   ✅   |
| Pendaftaran |   ✅    |  ✅   |   ✅   |

#### RESTful API (CRUD via Controller)
| Endpoint           | Index | Store | Show | Update | Destroy |
| :----------------- | :---: | :---: | :--: | :----: | :-----: |
| `api/siswa`        |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    |
| `api/pelatih`      |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    |
| `api/jadwal`       |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    |
| `api/pendaftaran`  |  ✅   |  ✅   |  ✅  |   ✅   |   ✅    |
| `api/presensi`     |  ❌   |  ❌   |  ❌  |   ❌   |   ❌    |

#### Halaman Web (Views Blade)
| Halaman               | File Ada | Data Dinamis (API) | UI Lengkap |
| :-------------------- | :------: | :----------------: | :--------: |
| **Admin Dashboard**   |    ✅    |        🔶          |     🔶     |
| **Admin Siswa**       |    ✅    |        ✅          |     ✅     |
| **Admin Pelatih**     |    ✅    |        ✅          |     ✅     |
| **Admin Jadwal**      |    ✅    |        ✅          |     ✅     |
| **Admin Pendaftaran** |    ✅    |        ✅          |     ✅     |
| **Admin Presensi**    |    ✅    |        🔶          |     🔶     |
| **Admin Sesi**        |    ✅    |        ❌          |     🔶     |
| **Admin Laporan**     |    ✅    |        ❌          |     🔶     |
| **Login**             |    ✅    |        🔶          |     ✅     |
| **Register**          |    ✅    |        🔶          |     ✅     |
| **Pelatih Dashboard** |    ✅    |        ❌          |     🔶     |
| **Pelatih Jadwal**    |    ✅    |        ❌          |     🔶     |
| **Pelatih Presensi**  |    ✅    |        ❌          |     🔶     |
| **Pelatih Siswa**     |    ✅    |        ❌          |     🔶     |
| **Siswa Dashboard**   |    ✅    |        ❌          |     🔶     |
| **Siswa Jadwal**      |    ✅    |        ❌          |     🔶     |
| **Siswa Presensi**    |    ✅    |        ❌          |     🔶     |
| **Siswa Sesi**        |    ✅    |        ❌          |     🔶     |

> ✅ = Selesai &nbsp; 🔶 = Setengah / Sebagian &nbsp; ❌ = Belum Dibuat

#### Sistem Lainnya
| Komponen                  | Status |
| :------------------------ | :----: |
| Autentikasi Backend Nyata |   ❌   |
| Middleware Role-based     |   ❌   |
| Token Auth (Sanctum)      |   ❌   |
| PWA (manifest + SW)       |   ❌   |
| Unit / Feature Test       |   🔶   |
| Deployment Production     |   ❌   |

---

## 🛣️ ROADMAP PER FASE

---

### 🔵 FASE 1: Penyempurnaan Backend & API (Prioritas Utama)
> **Target:** Semua endpoint API berfungsi dengan validasi yang kokoh.

#### 1.1 API Presensi (CRUD)
- [ ] Buat `PresensiController.php` di folder `app/Http/Controllers/Api/`
- [ ] Daftarkan route: `Route::apiResource('presensi', PresensiController::class)` di `api.php`
- [ ] Endpoint: `GET /api/presensi` — Ambil semua data presensi (dengan relasi siswa, pelatih, jadwal)
- [ ] Endpoint: `POST /api/presensi` — Input presensi baru (pelatih menandai kehadiran siswa)
- [ ] Endpoint: `PUT /api/presensi/{id}` — Edit data presensi
- [ ] Endpoint: `DELETE /api/presensi/{id}` — Hapus data presensi
- [ ] Validasi: siswa_id, jadwal_id, tanggal, status (hadir/izin/sakit/alpha)

#### 1.2 Logika Sesi Latihan
- [ ] Pastikan field `total_sesi` dan `sesi_terpakai` di tabel siswa terupdate otomatis ketika presensi dengan status "hadir" dibuat
- [ ] Buat endpoint atau logika untuk menghitung sisa sesi: `sisa_sesi = total_sesi - sesi_terpakai`
- [ ] Tambahkan peringatan otomatis jika sisa sesi siswa tinggal ≤ 2

#### 1.3 Logika Laporan
- [ ] Buat endpoint `GET /api/laporan/ringkasan` — Mengembalikan statistik: total siswa aktif, total sesi minggu ini, persentase kehadiran, dll.
- [ ] Buat endpoint `GET /api/laporan/presensi?bulan=7&tahun=2026` — Rekap presensi per bulan

---

### 🟢 FASE 2: Penyelesaian Halaman Web Admin
> **Target:** Semua halaman admin sudah terhubung ke API dan menampilkan data dinamis.

#### 2.1 Halaman Presensi Admin
- [ ] Hubungkan `admin/presensi.blade.php` dengan `GET /api/presensi`
- [ ] Tambahkan form/modal untuk input presensi baru (pilih siswa, jadwal, tanggal, status kehadiran)
- [ ] Tambahkan filter berdasarkan tanggal, siswa, atau pelatih
- [ ] Buat fungsi CRUD presensi di `main.js` (seperti yang sudah dilakukan untuk siswa, pelatih, jadwal)

#### 2.2 Halaman Sesi Admin
- [ ] Hubungkan `admin/sesi.blade.php` dengan API siswa (untuk menampilkan sisa sesi masing-masing siswa)
- [ ] Ganti data statis/hardcoded menjadi data dinamis dari API
- [ ] Tampilkan progress bar sesi berdasarkan data aktual `sesi_terpakai / total_sesi`

#### 2.3 Halaman Laporan Admin
- [ ] Hubungkan `admin/laporan.blade.php` dengan endpoint laporan
- [ ] Tampilkan statistik ringkasan (total siswa, kehadiran minggu ini, dll.)
- [ ] Tampilkan rekap presensi dalam format tabel atau grafik sederhana

#### 2.4 Dashboard Admin
- [ ] Pastikan semua angka statistik di dashboard (total siswa, pelatih aktif, jadwal hari ini) diambil dari API secara dinamis
- [ ] Pastikan notifikasi/peringatan sisa sesi muncul di dashboard

---

### 🟡 FASE 3: Sistem Autentikasi & Keamanan
> **Target:** Login yang aman menggunakan database, bukan hanya `localStorage`.

#### 3.1 Autentikasi Backend Nyata
- [ ] Instal dan konfigurasi **Laravel Sanctum** untuk Token-based Authentication
- [ ] Buat endpoint `POST /api/login` — Menerima email+password, mengembalikan token + role
- [ ] Buat endpoint `POST /api/logout` — Menghapus/revoke token
- [ ] Buat endpoint `GET /api/user` — Mengembalikan data user yang sedang login berdasarkan token

#### 3.2 Middleware & Role-based Access
- [ ] Buat middleware `RoleMiddleware` untuk memvalidasi role user (admin/pelatih/siswa)
- [ ] Terapkan middleware di route `web.php`:
  - `/admin/*` → hanya bisa diakses role `admin`
  - `/pelatih/*` → hanya bisa diakses role `pelatih`
  - `/siswa/*` → hanya bisa diakses role `siswa`
- [ ] Terapkan middleware di route `api.php` agar endpoint API terproteksi token

#### 3.3 Update Login Frontend
- [ ] Ubah `auth.js` agar mengirim credentials ke `POST /api/login` (bukan hanya simpan role di localStorage)
- [ ] Simpan token dari response API ke localStorage/sessionStorage
- [ ] Sertakan token di header `Authorization: Bearer <token>` pada setiap request fetch ke API
- [ ] Redirect ke halaman sesuai role setelah login berhasil

---

### 🟠 FASE 4: Halaman Pelatih & Siswa (Persiapan PWA)
> **Target:** Halaman khusus pelatih dan siswa sudah berfungsi, responsif, dan terhubung API.

#### 4.1 Halaman Pelatih
- [ ] **Dashboard Pelatih:** Tampilkan jadwal melatih hari ini (dari `GET /api/jadwal` difilter berdasarkan pelatih yang login)
- [ ] **Jadwal Pelatih:** Tampilkan semua jadwal melatih mingguan pelatih tersebut
- [ ] **Presensi Pelatih:** Form untuk menandai kehadiran siswa (`POST /api/presensi`)
- [ ] **Siswa Pelatih:** Daftar siswa yang diajar oleh pelatih tersebut

#### 4.2 Halaman Siswa
- [ ] **Dashboard Siswa:** Tampilkan info sisa sesi, jadwal latihan terdekat
- [ ] **Jadwal Siswa:** Tampilkan jadwal latihan mingguan siswa tersebut
- [ ] **Presensi Siswa:** Tampilkan riwayat kehadiran siswa (read-only)
- [ ] **Sesi Siswa:** Tampilkan detail total sesi, sesi terpakai, dan sisa sesi

#### 4.3 Responsif (Mobile-Friendly)
- [ ] Pastikan semua halaman pelatih & siswa menggunakan layout **responsive** (tampil rapi di layar HP)
- [ ] Gunakan tombol besar dan navigasi sederhana yang nyaman digunakan dengan jempol
- [ ] Tambahkan **bottom navigation bar** untuk navigasi utama di mobile

---

### 🔴 FASE 5: Implementasi PWA (Progressive Web App)
> **Target:** Halaman pelatih & siswa bisa diinstal di HP seperti aplikasi mobile.

#### 5.1 Web App Manifest
- [ ] Buat file `public/manifest.json` berisi:
  - `name`: "SIMPEL-Fella"
  - `short_name`: "Fella"
  - `start_url`: "/login"
  - `display`: "standalone" (tampil tanpa address bar browser)
  - `theme_color` & `background_color`
  - `icons`: Ikon aplikasi ukuran 192x192 dan 512x512
- [ ] Daftarkan manifest di `<head>` layout Blade: `<link rel="manifest" href="/manifest.json">`

#### 5.2 Service Worker
- [ ] Buat file `public/sw.js` untuk:
  - Menyimpan cache aset statis (HTML, CSS, JS, gambar) agar aplikasi bisa dibuka cepat
  - Menangani mode offline (tampilkan pesan "Anda sedang offline" jika tidak ada koneksi)
- [ ] Daftarkan service worker di layout Blade (`app.blade.php`):
  ```javascript
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js');
  }
  ```

#### 5.3 Ikon & Splash Screen
- [ ] Buat ikon aplikasi (logo Simpel Fella) dalam format PNG:
  - `public/icons/icon-192x192.png`
  - `public/icons/icon-512x512.png`
- [ ] Tambahkan meta tag untuk iOS Safari:
  - `<meta name="apple-mobile-web-app-capable" content="yes">`
  - `<link rel="apple-touch-icon" href="/icons/icon-192x192.png">`

#### 5.4 Testing PWA
- [ ] Buka aplikasi di Chrome HP → pastikan muncul tombol "Instal Aplikasi" / "Add to Home Screen"
- [ ] Setelah diinstal, pastikan aplikasi terbuka tanpa address bar browser (mode standalone)
- [ ] Cek offline mode: matikan WiFi → buka aplikasi → halaman cache harus tetap tampil

---

### 🟣 FASE 6: Testing, Dokumentasi & Deployment
> **Target:** Proyek siap dipresentasikan dan di-deploy ke server production.

#### 6.1 Testing
- [ ] Tulis **Feature Test** untuk setiap endpoint API (CRUD siswa, pelatih, jadwal, presensi)
- [ ] Tulis **Feature Test** untuk autentikasi (login berhasil, login gagal, akses tanpa token)
- [ ] Jalankan semua test: `php artisan test`

#### 6.2 Dokumentasi
- [ ] Perbarui `README.md` dengan:
  - Deskripsi proyek
  - Cara instalasi dan menjalankan di lokal
  - Daftar endpoint RESTful API
  - Panduan penggunaan untuk Admin, Pelatih, dan Siswa
- [ ] Dokumentasikan arsitektur sistem (bisa menggunakan diagram di atas)

#### 6.3 Deployment
- [ ] Pilih hosting (contoh: Railway, Render, VPS, atau shared hosting PHP)
- [ ] Konfigurasi file `.env` production (database MySQL, APP_URL, dll.)
- [ ] Jalankan `php artisan migrate --seed` di server production
- [ ] Jalankan `npm run build` untuk compile aset frontend
- [ ] Pastikan URL production bisa diakses publik (agar dosen bisa menguji PWA dari HP mereka)

---

## 📅 Estimasi Waktu Pengerjaan

| Fase | Deskripsi                              | Estimasi     |
| :--- | :------------------------------------- | :----------- |
| 1    | Penyempurnaan Backend & API            | 2 – 3 hari   |
| 2    | Penyelesaian Halaman Web Admin         | 3 – 4 hari   |
| 3    | Sistem Autentikasi & Keamanan          | 2 – 3 hari   |
| 4    | Halaman Pelatih & Siswa (Responsif)    | 3 – 4 hari   |
| 5    | Implementasi PWA                       | 1 – 2 hari   |
| 6    | Testing, Dokumentasi & Deployment      | 2 – 3 hari   |
|      | **TOTAL ESTIMASI**                     | **13 – 19 hari** |

> **Catatan:** Estimasi waktu di atas mengasumsikan Anda bekerja full-time (6-8 jam/hari) dengan bantuan AI coding assistant. Waktu bisa lebih singkat atau lebih panjang tergantung kompleksitas fitur dan revisi dari dosen.

---

## 🎯 Urutan Prioritas (Apa yang Harus Dikerjakan Duluan?)

```
1. FASE 1 ──► Backend & API HARUS SELESAI DULUAN (fondasi)
2. FASE 2 ──► Web Admin berfungsi penuh (bukti CRUD + RESTful API)
3. FASE 3 ──► Autentikasi aman (syarat keamanan dari dosen)
4. FASE 4 ──► Halaman Pelatih & Siswa responsif (persiapan mobile)
5. FASE 5 ──► PWA (bukti "web antar aplikasi" untuk dosen)
6. FASE 6 ──► Testing & Deploy (siap presentasi)
```

> ⚠️ **PENTING:** Jangan lompat ke fase selanjutnya sebelum fase sebelumnya benar-benar tuntas. Backend yang rapih adalah kunci keberhasilan seluruh sistem.
