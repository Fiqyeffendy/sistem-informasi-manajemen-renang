<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\PelatihDashboardController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Halaman utama landing yang dapat diakses tanpa login.
Route::get('/', function () {
    return view('landing');
});

// Route autentikasi mengatur login, register, dan logout pengguna.
// Controller terkait ada di folder Auth.
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('auth.login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'register']);

// Semua halaman dashboard dilindungi middleware auth agar hanya pengguna yang login yang bisa masuk.
Route::middleware(['auth'])->group(function () {
    // Route admin hanya bisa diakses oleh pengguna dengan role admin.
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
        Route::view('/admin/siswa', 'admin.siswa')->name('admin.siswa');
        Route::view('/admin/pendaftaran', 'admin.pendaftaran')->name('admin.pendaftaran');
        Route::view('/admin/pelatih', 'admin.pelatih')->name('admin.pelatih');
        Route::view('/admin/jadwal', 'admin.jadwal')->name('admin.jadwal');
        Route::get('/admin/presensi', [AdminDashboardController::class, 'presensi'])->name('admin.presensi');
        Route::get('/admin/sesi', [AdminDashboardController::class, 'sesi'])->name('admin.sesi');
        Route::get('/admin/laporan', [AdminDashboardController::class, 'laporan'])->name('admin.laporan');
    });

    // Route pelatih hanya bisa diakses oleh pengguna dengan role pelatih.
    Route::middleware(['role:pelatih'])->group(function () {
        Route::get('/pelatih/dashboard', [PelatihDashboardController::class, 'dashboard'])->name('pelatih.dashboard');
        Route::get('/pelatih/jadwal', [PelatihDashboardController::class, 'jadwal'])->name('pelatih.jadwal');
        Route::get('/pelatih/siswa', [PelatihDashboardController::class, 'siswa'])->name('pelatih.siswa');
        Route::get('/pelatih/presensi', [PelatihDashboardController::class, 'presensi'])->name('pelatih.presensi');
        Route::post('/pelatih/presensi', [PelatihDashboardController::class, 'storePresensi'])->name('pelatih.presensi.store');
        Route::delete('/pelatih/presensi/{id}', [PelatihDashboardController::class, 'destroyPresensi'])->name('pelatih.presensi.destroy');
    });

    // Route siswa hanya bisa diakses oleh pengguna dengan role siswa.
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'dashboard'])->name('siswa.dashboard');
        Route::get('/siswa/jadwal', [SiswaDashboardController::class, 'jadwal'])->name('siswa.jadwal');
        Route::get('/siswa/presensi', [SiswaDashboardController::class, 'presensi'])->name('siswa.presensi');
        Route::get('/siswa/sesi', [SiswaDashboardController::class, 'sesi'])->name('siswa.sesi');
    });
});
