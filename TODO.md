# TODO Komentar di Web (Penjelasan Fungsi & Integrasi)

## Step 1 — Inventarisasi scope
- [x] Ambil pemahaman alur utama: routes web/api + controller dashboard (admin/pelatih/siswa) + auth.
- [ ] Buat daftar file target: PHP (Controllers/Models/Routes/Middleware), Blade (views), dan file front-end (JS/CSS) yang dipakai.

## Step 2 — Tambah komentar ke backend PHP
- [ ] Edit `routes/web.php` dan `routes/api.php` untuk menjelaskan integrasi route → controller.
- [ ] Tambah komentar di semua class & method pada:
  - [ ] `app/Http/Controllers/*.php`
  - [ ] `app/Http/Controllers/Api/*.php`
  - [ ] `app/Http/Controllers/Auth/*.php`
- [ ] Tambah komentar di model relasi pada `app/Models/*.php` (agar jelas dipakai di controller).

## Step 3 — Tambah komentar di Blade (view)
- [ ] Tambahkan komentar pada tiap halaman:
  - [ ] `resources/views/landing.blade.php`
  - [ ] `resources/views/admin/*.blade.php`
  - [ ] `resources/views/pelatih/*.blade.php`
  - [ ] `resources/views/siswa/*.blade.php`
  - [ ] `resources/views/auth/*.blade.php`
  - [ ] `resources/views/layouts/app.blade.php`

## Step 4 — Tambah komentar di Front-end
- [ ] Tambah komentar pada JS yang berinteraksi dengan backend API (mis. fetch/axios, event handler).
- [ ] Tambah komentar pada CSS yang penting (komponen/tema/login).

## Step 5 — Validasi
- [ ] Jalankan `php -l` / atau `php artisan test` (jika tersedia) untuk memastikan tidak ada sintaks PHP rusak.
- [ ] Buka beberapa halaman utama (login, dashboard siswa/pelatih/admin) untuk verifikasi tidak ada yang pecah.

