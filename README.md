# SIMPEL-Fella
**Sistem Informasi Manajemen Penjadwalan & Presensi – Les Renang**

---

## README Utama

README ini adalah dokumentasi utama untuk seluruh repository.
File `backend/README.md` telah dihapus agar tidak terjadi kebingungan. Silakan gunakan README di root `d:/simpel-fella/README.md`.

---

## Ringkasan Proyek

SIMPEL-Fella adalah aplikasi manajemen les renang yang mencakup:
- manajemen data siswa
- manajemen data pelatih
- penjadwalan latihan
- presensi latihan
- penghitungan sesi latihan
- laporan dasar

Aplikasi ini dibangun sebagai Laravel backend dengan tampilan UI Bootstrap.

---

## Struktur Repository

```
/simpel-fella
├── README.md               ← Dokumen utama proyek
├── TODO.md                 ← Daftar pekerjaan yang perlu diselesaikan
├── test-api.http           ← Koleksi request untuk API testing
└── backend/                ← Aplikasi Laravel utama
    ├── app/
    │   ├── Http/Controllers/
    │   │   └── Api/SiswaController.php
    │   └── Models/
    │       ├── Siswa.php
    │       └── User.php
    ├── bootstrap/
    ├── config/
    ├── database/
    │   ├── migrations/
    │   │   └── 2026_07_01_174109_create_siswa_table.php
    │   └── seeders/
    ├── public/
    │   ├── css/
    │   ├── js/
    │   └── index.php
    ├── resources/
    │   ├── css/
    │   ├── js/
    │   └── views/
    ├── routes/
    │   ├── api.php
    │   └── web.php
    ├── storage/
    ├── tests/
    └── vendor/
```

---

## Status Saat Ini

### Sudah ada
- Backend Laravel tersedia di `backend/`
- Route view per role terdaftar di `backend/routes/web.php`
- Layout aplikasi dan sidebar sudah dibuat di `backend/resources/views/layouts/app.blade.php`
- Login demo front-end ada di `backend/public/js/auth.js`
- Model `Siswa` dan migrasi `database/migrations/2026_07_01_174109_create_siswa_table.php`
- API CRUD `backend/routes/api.php` untuk `/api/siswa`
- Controller `App\Http\Controllers\Api\SiswaController`
- Frontend CRUD siswa sudah implementasi di `backend/public/js/main.js`

### Belum lengkap / masih prototype
- Autentikasi backend Laravel belum terhubung secara nyata
- Middleware dan otorisasi role belum diterapkan di backend
- Model/API untuk entitas `pelatih`, `jadwal`, `presensi`, `sesi`, dan `laporan` belum ada
- Sebagian besar halaman masih berupa UI statis atau demo
- Produksi deployment dan testing belum diselesaikan

### Tahap proyek saat ini
- Fase: **Prototype / early MVP**
- Kematangan: fitur `siswa` awal sudah ada, tetapi keseluruhan alur operasional belum lengkap
- Perkiraan: sekitar **30-40%** dari kebutuhan operasional penuh

### Mindmap Proyek (ringkas)
1. Ide & tujuan
   - Aplikasi manajemen penjadwalan dan presensi les renang
   - Target role: Admin, Pelatih, dan Siswa
2. Stack teknis
   - Backend: Laravel 13 + PHP 8.3
   - Frontend: Blade + Bootstrap + Vanilla JS
   - Build: Vite + Tailwind plugin
3. Backend yang sudah dibangun
   - Struktur aplikasi Laravel di `backend/`
   - Route view per role di `backend/routes/web.php`
   - Model `Siswa`, migrasi, API resource, controller CRUD
4. Frontend yang sudah dibangun
   - Layout utama dan sidebar role-based
   - Login demo berbasis role client-side
   - CRUD siswa via fetch ke `/api/siswa`
5. Gap utama menuju operasional
   - Auth backend nyata dan role-based access control
   - Model/API untuk Pelatih, Jadwal, Presensi, Sesi, Laporan
   - Halaman dinamis yang terhubung dengan data backend
   - Testing dan deployment
6. Siap operasional bila
   - Auth/login valid terpasang
   - Semua data entitas terstruktur dan terhubung
   - Semua halaman real-time menggunakan API nyata
   - Aplikasi diuji dan di-deploy pada environment produksi

---

## Cara Menjalankan (Backend Laravel)

1. Buka terminal di folder `backend/`
2. Salin file environment jika belum ada:
   ```powershell
   copy .env.example .env
   ```
3. Install dependency PHP:
   ```powershell
   composer install
   ```
4. Generate app key:
   ```powershell
   php artisan key:generate
   ```
5. Jalankan migrasi:
   ```powershell
   php artisan migrate
   ```
6. Install dependency Node/Vite:
   ```powershell
   npm install
   ```
7. Jalankan dev server:
   ```powershell
   npm run dev
   ```
8. Buka browser ke alamat server Laravel (default `http://127.0.0.1:8000`)

---

## Catatan Penting

- `backend/README.md` dihapus agar dokumentasi hanya ada di satu tempat.
- Jika kamu ingin meneruskan pengembangan, fokus pada:
  1. Auth Laravel nyata dan middleware role
  2. Model & API untuk pelatih, jadwal, presensi, sesi, laporan
  3. Integrasi view Blade dengan API nyata
  4. Menambahkan seeders dan tests

---

## Kontak Cepat

- Halaman login demo: `/login`
- API siswa: `/api/siswa`
- Route admin: `/admin/dashboard`
- Route pelatih: `/pelatih/dashboard`
- Route siswa: `/siswa/dashboard`
