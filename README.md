# 🏊‍♂️ SIMPEL-Fella
**Sistem Informasi Manajemen Penjadwalan & Presensi Les Renang Fella**

SIMPEL-Fella adalah platform manajemen les renang terintegrasi yang menggabungkan **Web Admin (Desktop)** untuk pengelolaan data terpusat dan **Progressive Web App (PWA) Mobile** untuk Pelatih dan Siswa/Orang Tua. Sistem ini dibangun dengan konsep **RESTful API** berbasis Laravel sebagai pusat data (Single Source of Truth).

---

## 🏛️ Arsitektur Proyek
Aplikasi menggunakan arsitektur **Monolitik Hybrid dengan RESTful API**:
*   **Backend:** PHP (Laravel Framework) bertindak sebagai API Engine dan Database Manager.
*   **Web Admin:** Desktop-optimized dashboard menggunakan Laravel Blade & Bootstrap.
*   **PWA Mobile (Pelatih & Siswa):** Mobile-optimized responsive views yang didukung oleh Web App Manifest dan Service Worker sehingga dapat diinstal di HP layaknya aplikasi native.

---

## 📂 Struktur Direktori Utama
Proyek sekarang berada langsung di root folder `simpel-fella/` (Monorepo):
```text
simpel-fella/
├── app/                  ← Logika PHP, Model, Controller (Api/ & Web/)
├── bootstrap/            ← Konfigurasi inisialisasi framework
├── config/               ← File konfigurasi Laravel (Database, CORS, Auth, dll)
├── database/             ← Migrasi database, Seeders untuk data awal
├── public/               ← File publik (.htaccess, CSS, JS, manifest.json, sw.js)
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
*   **Framework Backend:** Laravel
*   **Database:** PostgreSQL (Production) / SQLite atau MySQL (Lokal)
*   **Frontend UI:** Laravel Blade, Bootstrap 5, Vanilla CSS
*   **API Protocol:** RESTful API (JSON Response)
*   **Mobile Tech:** PWA (Web App Manifest + Service Worker)

---

## ⚡ Cara Menjalankan di Lokal

### Prasyarat
*   PHP >= 8.2
*   Composer
*   Node.js & NPM
*   Database (PostgreSQL, MySQL, atau SQLite)

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
3.  **Install dependensi PHP & JavaScript:**
    ```bash
    composer install
    npm install
    ```
4.  **Buat App Key Laravel:**
    ```bash
    php artisan key:generate
    ```
5.  **Jalankan Migrasi & Database Seeder:**
    ```bash
    php artisan migrate:fresh --seed
    ```
6.  **Jalankan Server Lokal:**
    *   Terminal 1 (Laravel Server):
        ```bash
        php artisan serve
        ```
    *   Terminal 2 (Vite Compiler):
        ```bash
        npm run dev
        ```
7.  Akses web melalui browser di alamat `http://127.0.0.1:8000`.

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
*   PWA Pelatih: `/pelatih/dashboard`, `/pelatih/presensi`, dll.
*   PWA Siswa: `/siswa/dashboard`, `/siswa/sesi`, dll.
