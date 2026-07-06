<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\PelatihController;
use App\Http\Controllers\Api\JadwalController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API Routes untuk SISWA
Route::apiResource('siswa', SiswaController::class);

// API Routes untuk PENDAFTARAN
Route::apiResource('pendaftaran', PendaftaranController::class);

// API Routes untuk PELATIH
Route::apiResource('pelatih', PelatihController::class);

// API Routes untuk JADWAL
Route::apiResource('jadwal', JadwalController::class);