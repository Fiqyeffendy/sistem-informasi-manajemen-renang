<?php

namespace App\Providers;

use App\Models\Presensi;
use App\Observers\PresensiObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // Tempat mendaftarkan layanan tambahan jika dibutuhkan.
    public function register(): void
    {
        //
    }

    // Saat aplikasi boot, pasang observer agar presensi otomatis mempengaruhi sesi siswa.
    public function boot(): void
    {
        Presensi::observe(PresensiObserver::class);
    }
}
