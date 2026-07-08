<?php

namespace Database\Seeders;

use App\Enums\JenisProgram;
use App\Enums\LokasiLes;
use App\Enums\Program;
use App\Models\Pelatih;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    // Seeder ini membuat akun awal admin dan pelatih untuk menjalankan aplikasi secara langsung.
    public function run(): void
    {
        // Buat akun admin default agar panel admin bisa diakses segera.
        User::firstOrCreate(['email' => 'admin@fella.id'], [
            'name'     => 'Admin Fella',
            'email'    => 'admin@fella.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Buat data pelatih contoh dan akun login terkait untuk pengujian awal.
        $pelatih1 = Pelatih::create([
            'nama'             => 'Rizal Maulana',
            'no_hp'            => '081234560001',
            'email'            => 'rizal@fella.id',
            'spesialisasi'     => ['Toddler', 'Kids'],
            'jadwal_mengajar'  => [
                ['hari' => 'Senin',  'jam' => '06:00'],
                ['hari' => 'Rabu',   'jam' => '08:00'],
                ['hari' => 'Jumat',  'jam' => '06:30'],
            ],
            'status'           => 'aktif',
        ]);

        // Buat user untuk pelatih agar bisa login
        User::create([
            'name'       => $pelatih1->nama,
            'email'      => $pelatih1->email,
            'password'   => Hash::make('password'),
            'role'       => 'pelatih',
            'pelatih_id' => $pelatih1->id,
        ]);
    }
}
