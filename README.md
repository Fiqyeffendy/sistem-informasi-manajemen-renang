# 🏊‍♂️ SIMPEL-Fella
**Sistem Informasi Manajemen Pelatihan & Presensi Les Renang Fella**

SIMPEL-Fella adalah platform manajemen les renang terintegrasi yang menggabungkan **Web Admin (Desktop)** untuk pengelolaan data terpusat dan **Web Mobile Responsif** untuk Pelatih dan Siswa/Orang Tua. Sistem ini dibangun dengan konsep **RESTful API** berbasis Laravel 13 sebagai pusat data (*Single Source of Truth*).

### 👥 Anggota Kelompok
* **Muchammad Fiqy Effendy** (108)
* **Ahmad Fathur Rahman** (084)
* **Adjie Saputra W.** (075)
* **Rachmat Alfian Akbar** (102)
* **Aditya Maulana** (077)

---

## 🚀 Fitur Utama

Sistem ini dirancang untuk mempermudah operasional kursus renang dengan 3 hak akses (Multi-Role):

1.  **Dashboard Admin (Desktop):**
    *   Statistik data ringkas (Total Siswa, Kelas Aktif, Pelatih, Kehadiran Hari Ini).
    *   Pengelolaan data induk (Siswa, Pelatih, Jadwal Kelas, Pendaftaran Baru).
    *   Monitoring sisa sesi aktif siswa secara real-time.
    *   Pelaporan kehadiran dan perkembangan latihan.
2.  **Dashboard Pelatih (Mobile Responsive):**
    *   Melihat jadwal mengajar pribadi (Hari & Jam).
    *   Melihat daftar siswa di bawah binaannya.
    *   Melakukan input presensi latihan (Hadir, Izin, Alpha) dengan catatan evaluasi perkembangan siswa.
3.  **Dashboard Siswa / Orang Tua (Mobile Responsive):**
    *   Melihat sisa sesi latihan yang masih aktif.
    *   Melihat jadwal latihan renang pribadi yang terdaftar.
    *   Melacak riwayat presensi beserta catatan evaluasi dari pelatih.

---

## 🏛️ Arsitektur Proyek
Aplikasi menggunakan arsitektur **Monolitik Hybrid dengan RESTful API**:
*   **Backend:** PHP 8.3+ dengan **Laravel 13 Framework** bertindak sebagai API Engine dan Database Manager.
*   **Frontend Web Admin & Mobile View:** Menggunakan Laravel Blade dengan perpaduan **Tailwind CSS v4** (melalui compiler Vite) dan **Bootstrap v5.3.3** untuk layout responsif premium.
*   **RESTful API:** Menyediakan endpoint mandiri (`/api/*`) untuk integrasi data yang bersih.

---

## 📊 Spesifikasi Stack Teknologi
*   **Bahasa Utama:** PHP >= 8.3 (Backend) & JavaScript ES6 (Frontend)
*   **Framework Backend:** Laravel 13.x
*   **Database:** PostgreSQL (dioperasikan & dikelola dengan pgAdmin 4)
*   **Frontend UI Compiler:** Vite + Tailwind CSS v4 & Bootstrap v5.3.3
*   **API Protocol:** RESTful API (JSON Response)

---

## 📂 Struktur Direktori Utama
Proyek menggunakan struktur monorepo Laravel terstandarisasi:
```text
simpel-fella/
├── app/                  ← Logika PHP, Model, Controller, Enums
│   ├── Enums/            ← Definisi Enum (JenisProgram, LokasiLes, Program)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/      ← Controller khusus RESTful API (CRUD)
│   │   │   ├── Auth/     ← Controller Autentikasi (Login, Register)
│   │   │   └── *.php     ← Controller Dashboard View (Admin, Pelatih, Siswa)
│   │   └── Middleware/   ← Proteksi hak akses & Autentikasi role
│   └── Models/           ← Relasi database (Siswa, Pelatih, Jadwal, Presensi, User)
├── bootstrap/            ← Konfigurasi inisialisasi framework
├── config/               ← File konfigurasi Laravel (Database, CORS, Auth, dll)
├── database/             ← Migrasi database, Seeders data demo
├── public/               
│   └── css/              ← Global Custom CSS (variables.css, shell.css, components.css)
├── resources/            
│   ├── css/              ← Integrasi Tailwind CSS v4 (`app.css`)
│   ├── js/               ← Handler frontend JS (auth.js, main.js)
│   └── views/            ← Template Blade (admin/, pelatih/, siswa/, layouts/)
├── routes/               
│   ├── api.php           ← Registrasi endpoint RESTful API (/api/*)
│   └── web.php           ← Registrasi rute web / views
├── tests/                ← Unit & Feature automated testing
├── vite.config.js        ← Konfigurasi Vite & Tailwind compiler
├── ROADMAP.md            ← Dokumen perencanaan tahapan fitur
└── TODO.md               ← Checklist pekerjaan
```

---

## ⚡ Cara Menjalankan di Lokal

### Prasyarat
*   PHP >= 8.3
*   Composer
*   Node.js & NPM
*   PostgreSQL Database (dan pgAdmin 4 sebagai GUI tool)

### Langkah Instalasi
1.  **Clone repository** dan masuk ke direktori proyek:
    ```bash
    git clone https://gitlab.com/muchammadfiqyeffendy/simpel-fella.git
    cd simpel-fella
    ```
2.  **Salin konfigurasi environment:**
    ```bash
    cp .env.example .env
    ```
    *Sesuaikan isian database (`DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) pada file `.env` baru Anda agar terhubung dengan PostgreSQL.*
    
3.  **Jalankan Inisialisasi Otomatis (Setup Script):**
    Aplikasi menyediakan script setup terintegrasi untuk menginstall dependensi PHP/Node, membuat `.env`, generate app key, migrasi database, dan membuild aset frontend:
    ```bash
    composer run setup
    ```
4.  **Jalankan Migrasi & Database Seeder (Manual - Jika dibutuhkan):**
    ```bash
    php artisan migrate:fresh --seed
    ```
5.  **Jalankan Server Lokal:**
    *   **Metode 1 (Satu Perintah - Direkomendasikan):**
        Jalankan server PHP, Laravel queue listener, logger Pail, dan Vite compiler sekaligus dalam satu terminal menggunakan Composer script:
        ```bash
        composer run dev
        ```
    *   **Metode 2 (Manual - Dua Terminal):**
        *   Terminal 1 (Laravel Server): `php artisan serve`
        *   Terminal 2 (Vite Compiler): `npm run dev`

6.  Akses web melalui browser di alamat `http://127.0.0.1:8000`.

---

## 🔑 Akun Demo (Hasil Seeder)
Gunakan akun-akun berikut untuk masuk ke sistem setelah menjalankan seeder:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@fella.id` | `password` | Mengakses dashboard admin utama & seluruh CRUD data |
| **Pelatih** | `rizal@fella.id` | `password` | Mengakses jadwal mengajar, siswa binaan, & presensi siswa |

> [!NOTE]
> Untuk role **Siswa**, Anda dapat melakukan pendaftaran akun baru secara mandiri melalui menu **Daftar Sekarang** pada halaman `/register` untuk mendapatkan akses ke dashboard siswa.

---

## 🧪 Pengujian Otomatis (Testing)
Untuk memastikan seluruh logika bisnis, relasi database, dan endpoint API berfungsi dengan baik, jalankan automated testing bawaan:
```bash
composer run test
# atau
php artisan test
```

---

## 🔗 Rute Utama & Endpoint API

### Halaman Web View
*   **Landing Page:** `/`
*   **Autentikasi:** `/login` & `/register`
*   **Admin Panel:** 
    *   Dashboard: `/admin/dashboard`
    *   Kelola Siswa: `/admin/siswa`
    *   Kelola Pelatih: `/admin/pelatih`
    *   Kelola Pendaftaran: `/admin/pendaftaran`
    *   Kelola Jadwal: `/admin/jadwal`
    *   Kelola Kehadiran: `/admin/presensi`
    *   Kelola Sesi Siswa: `/admin/sesi`
    *   Laporan Bulanan: `/admin/laporan`
*   **Dashboard Pelatih:**
    *   Beranda Pelatih: `/pelatih/dashboard`
    *   Jadwal Mengajar: `/pelatih/jadwal`
    *   Siswa Binaan: `/pelatih/siswa`
    *   Input Presensi: `/pelatih/presensi`
*   **Dashboard Siswa:**
    *   Beranda Siswa: `/siswa/dashboard`
    *   Jadwal Latihan: `/siswa/jadwal`
    *   Riwayat Kehadiran: `/siswa/presensi`
    *   Sisa Sesi Aktif: `/siswa/sesi`

### RESTful API Endpoints (`/api/*`)
*   `GET /api/user` — Mengecek user yang sedang login (Sanctum Authenticated)
*   `api/siswa` — CRUD Data Siswa
*   `api/pelatih` — CRUD Data Pelatih
*   `api/pendaftaran` — CRUD Pendaftaran Siswa Baru
*   `api/jadwal` — CRUD Jadwal Latihan
*   `api/presensi` — CRUD Riwayat Kehadiran

---

## 📚 Panduan Teknis & Jawaban 

### 1. File Konfigurasi Database yang Digunakan

Konfigurasi database pada aplikasi ini terdapat pada dua file, yaitu **`.env`** dan **`config/database.php`**.

- **`config/database.php`** berfungsi sebagai konfigurasi utama database pada Laravel. File ini menyediakan pengaturan untuk beberapa driver database yang didukung, seperti MySQL, PostgreSQL, SQLite, dan SQL Server. Nilai konfigurasi yang digunakan diambil dari variabel yang terdapat pada file `.env`.

- **`.env`** digunakan untuk menyimpan konfigurasi koneksi database yang digunakan oleh aplikasi, meliputi jenis database, host, port, nama database, username, dan password. Pada aplikasi ini, database yang digunakan adalah PostgreSQL dengan konfigurasi sebagai berikut.

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=namadb
DB_USERNAME=usrnmedb
DB_PASSWORD=password
```

Pemisahan konfigurasi ini memudahkan pengelolaan web karena perubahan informasi koneksi database dapat dilakukan melalui file `.env` tanpa perlu mengubah kode program pada `config/database.php`.

### 2. Bagaimana Cara Membuat Route Baru di Aplikasi?
Cara mengarahkan URL yang diketik pengguna di browser agar membuka halaman atau fitur yang pas. Proses pembuatannya:
1.  **Pilih File Rutenya:** 
    Laravel menyediakan filenya di dalam folder `routes/`. Di aplikasi ini, daftarkan lewat [[bootstrap/app.php](file:///d:/simpel-fella/bootstrap/app.php)].
    *   [[routes/web.php](file:///d:/simpel-fella/routes/web.php)] untuk membuat rute halaman biasa (web dashboard).
    *   [[routes/api.php](file:///d:/simpel-fella/routes/api.php)] untuk membuat rute data API (format JSON).
2.  **Tulis Rutenya:**
    Menggunakan fungsi `Route` diikuti metodenya (`get` untuk menampilkan halaman, atau `post` untuk mengirim data/form).
    *   *Contoh kalau mau buat halaman baru:*
        ```php
        Route::get('/halaman-baru', [NamaController::class, 'namaFungsi'])->name('halaman.baru');
        ```
    *   *Atau bisa juga langsung ngerender tampilan (view) tanpa controller:*
        ```php
        Route::view('/kontak', 'kontak')->name('kontak');
        ```
3.  **Kasih Pengaman (Middleware):**
    Supaya rute tidak bisa dibuka sembarangan orang, route dibungkus pakai middleware seperti `auth` (harus login dulu) atau `role` (harus punya akses tertentu).

---

### 3. Bagaimana Sistem Membagi Hak Akses (Role)?
Aplikasi ini punya 3 tingkat hak akses (role): **Admin**, **Pelatih**, dan **Siswa**. Cara membatasinya:
1.  **Di Database:** Tabel `users` punya kolom `role` untuk menyimpan status pengguna (berupa tulisan `admin`, `pelatih`, atau `siswa`).
2.  **Pintu Gerbang (Middleware):** Alat pemeriksa otomatis bernama [[EnsureUserHasRole.php](file:///d:/simpel-fella/app/Http/Middleware/EnsureUserHasRole.php)]. 
    *   Tugas alat ini: pas ada user yang mau buka halaman, dia cek dulu *"User ini rolenya apa?"*.
    *   Kalau rolenya cocok dengan yang diminta halaman tersebut, dibolehkan masuk. Kalau tidak cocok, sistem langsung menolak dan menampilkan error *403 Forbidden* ("Anda tidak memiliki akses").
3.  **Pemasangan di Rute:** Alat ini diberi nama panggilan `role` di file [[bootstrap/app.php](file:///d:/simpel-fella/bootstrap/app.php)]. Setelah itu tinggal tempel di [[routes/web.php](file:///d:/simpel-fella/routes/web.php)]:
    *   `Route::middleware(['role:admin'])` = semua rute di dalamnya cuma bisa diakses oleh Admin.
    *   `Route::middleware(['role:pelatih'])` = semua rute di dalamnya cuma bisa diakses oleh Pelatih.
    *   `Route::middleware(['role:siswa'])` = semua rute di dalamnya cuma bisa diakses oleh Siswa.

---

### 4. Langkah-Langkah Mengubah Database dari PostgreSQL ke MySQL
Jika ingin menganti database sistem dari PostgreSQL ke MySQL : 
1.  **Mengedit File [[.env](file:///d:/simpel-fella/.env)]:**
    Mengubah nilai variabel database dari driver `pgsql` menjadi `mysql` beserta port defaultnya (`3306`):
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama
    DB_USERNAME=username
    DB_PASSWORD=password
    ```
2.  **Mengaktifkan Ekstensi PHP MySQL:**
    Mengekstensi `pdo_mysql` harus sudah terpasang dan aktif di file konfigurasi `php.ini` server/PC.
3.  **Membuat Database Baru:**
    Membuka MySQL client, lalu membuat database kosong baru dengan nama yang sama seperti nilai `DB_DATABASE` di `.env` tadi (contoh: `nama_database_mysql`).
4.  **Menjalankan Ulang Migrasi:**
    Membuka terminal di folder project, lalu menjalankan perintah untuk membuat semua tabel baru secara otomatis beserta data contohnya:
    ```bash
    php artisan migrate:fresh --seed
    ```

---

### 5. Cara Deploy Web ke Server Agar Bisa Online
Supaya web ini bisa diakses lewat internet oleh orang lain, berikut adalah tahapan deployment-nya:
1.  **Menyiapkn Server:** Sewa VPS dan install web server (Nginx/Apache), PHP (versi terbaru beserta ekstensi database), database server (MySQL/PostgreSQL), Composer, dan Node.js.
2.  **Upload & Install Code:**
    *   Clone project dari repository Git ke server.
    *   Menjalankan perintah `composer install --no-dev --optimize-autoloader` di terminal server agar semua library PHP terinstall dengan versi yang ringan dan cepat khusus untuk produksi.
3.  **Setup `.env` Produksi:**
    Membuat file `.env` di server :
    *   Mengganti `APP_ENV=production`.
    *   Mengganti `APP_DEBUG=false` 
    *   Mengisi domain website Anda di `APP_URL`.
    *   Memasukkan password database server asli.
4.  **Siapkan Database & Kunci Pengaman:**
    Menjalankan perintah di server untuk membuat kunci enkripsi dan struktur database:
    ```bash
    php artisan key:generate
    php artisan migrate --force --seed
    ```
5.  **Build Tampilan (Vite):**
    Menjalankan perintah untuk mengunduh modul CSS/JS dan melakukan kompilasi produksi agar website dapat dimuat dengan cepat:
    ```bash
    npm install
    npm run build
    ```
6.  **Optimalkan Kecepatan (Cache):**
    Menjalankan perintah cache agar server tidak perlu membaca ulang file konfigurasi setiap kali ada pengunjung:
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```
7.  **Atur Izin Folder:**
    Memberikan akses tulis pada folder `storage` dan `bootstrap/cache` agar web server bisa menulis file log/sesi pengunjung:
    ```bash
    chown -R www-data:www-data storage bootstrap/cache
    chmod -R 775 storage bootstrap/cache
    ```
8.  **Setting Nginx & SSL:**
    *   Mengarahkan domain ke folder `/var/www/simpel-fella/public` (wajib folder `public` agar file sistem tidak bisa diintip orang).
    *   Memasang SSL gratis pakai Certbot (Let's Encrypt) biar alamat website menggunakan https.

