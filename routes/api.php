<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\PelatihController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\PresensiController;

// Endpoint API sederhana untuk mengecek user yang sedang login.
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API CRUD untuk data siswa.
Route::apiResource('siswa', SiswaController::class);

// API CRUD untuk alur pendaftaran siswa baru.
Route::apiResource('pendaftaran', PendaftaranController::class);

// API CRUD untuk data pelatih.
Route::apiResource('pelatih', PelatihController::class);

// API CRUD untuk data jadwal latihan.
Route::apiResource('jadwal', JadwalController::class);

// API CRUD untuk pencatatan presensi.
Route::apiResource('presensi', PresensiController::class);

