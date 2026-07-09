# 🏊‍♂️ SIMPEL-Fella
**Sistem Informasi Manajemen Penjadwalan & Presensi Les Renang Fella**

SIMPEL-Fella adalah platform manajemen les renang terintegrasi yang menggabungkan **Web Admin (Desktop)** untuk pengelolaan data terpusat dan **Web Mobile Responsif (PWA-Ready)** untuk Pelatih dan Siswa/Orang Tua. Sistem ini dibangun dengan konsep **RESTful API** berbasis Laravel sebagai pusat data (Single Source of Truth).

---

## 🏛️ Arsitektur Proyek
Aplikasi menggunakan arsitektur **Monolitik Hybrid dengan RESTful API**:
*   **Backend:** PHP (Laravel Framework) bertindak sebagai API Engine dan Database Manager.
*   **Web Admin:** Desktop-optimized dashboard menggunakan Laravel Blade & Tailwind CSS v4.
*   **Mobile Web (Pelatih & Siswa):** Tampilan mobile-responsive yang dioptimalkan untuk diakses melalui smartphone, dirancang siap untuk dikonversi menjadi Progressive Web App (PWA) lengkap dengan Web App Manifest dan Service Worker (PWA-ready).

---

## 📂 Struktur Direktori Utama
Proyek sekarang berada langsung di root folder `simpel-fella/` (Monorepo):
```text
simpel-fella/
├── app/                  ← Logika PHP, Model, Controller (Api/ & Web/)
├── bootstrap/            ← Konfigurasi inisialisasi framework
├── config/               ← File konfigurasi Laravel (Database, CORS, Auth, dll)
├── database/             ← Migrasi database, Seeders untuk data awal
├── public/               ← File publik (.htaccess, favicon.ico, dll)
├── resources/            
│   ├── css/              ← Global stylesheet
│   ├── js/               ← Handler frontend JS (auth.js, main.js)
│   └── views/            ← Template Blade (admin/, pelatih/, siswa/, layouts/)
├── routes/               
│   ├── api.php           ← Registrasi endpoint RESTful API (/api/*)
│   └── web.php           ← Registrasi rute web / views
├── tests/                ← Unit & Feature automated testing
├── vite.config.js        ← Konfigurasi kompilasi aset frontend
├── ROADMAP.md            ← Dokumen perencanaan tahapan fitur
└── TODO.md               ← Checklist pekerjaan
```

---

## 📊 Spesifikasi Stack Teknologi
*   **Bahasa Utama:** PHP (Backend) & JavaScript (Frontend)
*   **Framework Backend:** Laravel 13
*   **Database:** PostgreSQL (dioperasikan & dikelola dengan pgAdmin 4)
*   **Frontend UI:** Laravel Blade, Tailwind CSS v4 (terintegrasi dengan Vite)
*   **API Protocol:** RESTful API (JSON Response)
*   **Mobile Tech:** Mobile-responsive Web (PWA-ready)

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
    *Sesuaikan isian database (`DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) pada file `.env` baru Anda.*
3.  **Jalankan Inisialisasi Otomatis (Setup):**
    Aplikasi menyediakan script setup terintegrasi untuk menginstall dependensi, membuat `.env`, generate app key, menjalankan migrasi database, dan membuild aset frontend:
    ```bash
    composer run setup
    ```
    *(Pastikan Anda telah menyesuaikan kredensial database PostgreSQL di file `.env` baru Anda jika ingin menggunakan pgAdmin 4/Postgres sebelum menjalankan command di bawah).*
    
4.  **Jalankan Migrasi & Database Seeder (Manual - Jika dibutuhkan):**
    ```bash
    php artisan migrate:fresh --seed
    ```
5.  **Jalankan Server Lokal:**
    *   Terminal 1 (Laravel Server):
        ```bash
        php artisan serve
        ```
    *   Terminal 2 (Vite Compiler):
        ```bash
        npm run dev
        ```
6.  Akses web melalui browser di alamat `http://127.0.0.1:8000`.

---

## 🔑 Akun Demo (Hasil Seeder)
Gunakan akun-akun berikut untuk masuk ke sistem setelah menjalankan seeder:

| Role | Email | Password | Catatan |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@fella.id` | `password` | Mengakses dashboard admin utama |
| **Pelatih** | `rizal@fella.id` | `password` | Mengakses jadwal mengajar & presensi siswa |

---

## 🧪 Cara Menjalankan Pengujian otomatis (Testing)
Untuk memastikan tidak ada logika bisnis atau endpoint API yang rusak, jalankan automated testing bawaan:
```bash
php artisan test
```

---

## 🔗 Endpoint RESTful API & Rute Utama

### RESTful API Endpoints (`/api/*`)
*   `api/siswa` — CRUD Data Siswa
*   `api/pelatih` — CRUD Data Pelatih
*   `api/pendaftaran` — CRUD Pendaftaran Siswa Baru
*   `api/jadwal` — CRUD Jadwal Latihan
*   `api/presensi` — CRUD Riwayat Kehadiran (Fase 1)

### Halaman Web View
*   Login: `/login`
*   Admin Panel: `/admin/dashboard`, `/admin/siswa`, `/admin/jadwal`, dll.
*   Dashboard Pelatih: `/pelatih/dashboard`, `/pelatih/presensi`, dll.
*   Dashboard Siswa: `/siswa/dashboard`, `/siswa/sesi`, dll.
