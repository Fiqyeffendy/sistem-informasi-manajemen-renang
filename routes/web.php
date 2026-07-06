<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::view('/login', 'auth.login')->name('auth.login');
Route::view('/register', 'auth.register')->name('auth.register');

Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
Route::view('/admin/siswa', 'admin.siswa')->name('admin.siswa');
Route::view('/admin/pendaftaran', 'admin.pendaftaran')->name('admin.pendaftaran');
Route::view('/admin/pelatih', 'admin.pelatih')->name('admin.pelatih');
Route::view('/admin/jadwal', 'admin.jadwal')->name('admin.jadwal');
Route::view('/admin/presensi', 'admin.presensi')->name('admin.presensi');
Route::view('/admin/sesi', 'admin.sesi')->name('admin.sesi');
Route::view('/admin/laporan', 'admin.laporan')->name('admin.laporan');

Route::view('/pelatih/dashboard', 'pelatih.dashboard')->name('pelatih.dashboard');
Route::view('/pelatih/jadwal', 'pelatih.jadwal')->name('pelatih.jadwal');
Route::view('/pelatih/siswa', 'pelatih.siswa')->name('pelatih.siswa');
Route::view('/pelatih/presensi', 'pelatih.presensi')->name('pelatih.presensi');

Route::view('/siswa/dashboard', 'siswa.dashboard')->name('siswa.dashboard');
Route::view('/siswa/jadwal', 'siswa.jadwal')->name('siswa.jadwal');
Route::view('/siswa/presensi', 'siswa.presensi')->name('siswa.presensi');
Route::view('/siswa/sesi', 'siswa.sesi')->name('siswa.sesi');
