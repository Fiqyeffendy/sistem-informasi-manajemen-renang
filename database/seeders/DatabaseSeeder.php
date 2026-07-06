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
    public function run(): void
    {
        // ── 1. Admin User ───────────────────────────────────────────
        User::firstOrCreate(['email' => 'admin@fella.id'], [
            'name'     => 'Admin Fella',
            'email'    => 'admin@fella.id',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── 2. Pelatih ──────────────────────────────────────────────
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

        $pelatih2 = Pelatih::create([
            'nama'             => 'Sari Wahyuni',
            'no_hp'            => '081234560002',
            'email'            => 'sari@fella.id',
            'spesialisasi'     => ['Kids', 'Adults'],
            'jadwal_mengajar'  => [
                ['hari' => 'Senin',  'jam' => '07:00'],
                ['hari' => 'Selasa', 'jam' => '09:00'],
                ['hari' => 'Kamis',  'jam' => '16:00'],
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
        User::create([
            'name'       => $pelatih2->nama,
            'email'      => $pelatih2->email,
            'password'   => Hash::make('password'),
            'role'       => 'pelatih',
            'pelatih_id' => $pelatih2->id,
        ]);

        // ── 3. Siswa ─────────────────────────────────────────────────
        $siswaData = [
            ['nama' => 'Ahmad Fauzi',    'umur' => 10, 'program' => Program::SWIM_STARS,   'jenis_program' => JenisProgram::SMALL_GROUP,  'lokasi_les' => LokasiLes::ISTANA_MENTARI,  'total_sesi' => 20, 'sesi_terpakai' => 8],
            ['nama' => 'Budi Santoso',   'umur' => 12, 'program' => Program::SWIM_STARS,   'jenis_program' => JenisProgram::GROUP,         'lokasi_les' => LokasiLes::HOTEL_ASTON,     'total_sesi' => 16, 'sesi_terpakai' => 14],
            ['nama' => 'Citra Dewi',     'umur' => 25, 'program' => Program::AQUA_FIT,     'jenis_program' => JenisProgram::PRIVATE,       'lokasi_les' => LokasiLes::HOTEL_SWISS_BERLINN, 'total_sesi' => 20, 'sesi_terpakai' => 12],
            ['nama' => 'Rafi Pratama',   'umur' => 7,  'program' => Program::WATER_BABIES, 'jenis_program' => JenisProgram::SEMI_PRIVATE,  'lokasi_les' => LokasiLes::ISTANA_MENTARI,  'total_sesi' => 20, 'sesi_terpakai' => 18],
            ['nama' => 'Nadia Kusuma',   'umur' => 9,  'program' => Program::SWIM_STARS,   'jenis_program' => JenisProgram::SMALL_GROUP,   'lokasi_les' => LokasiLes::REGENCY_21,      'total_sesi' => 20, 'sesi_terpakai' => 16],
        ];

        $siswaModels = [];
        foreach ($siswaData as $data) {
            $siswaModels[] = Siswa::create($data);
        }

        // Buat user login untuk siswa pertama
        User::create([
            'name'     => $siswaModels[0]->nama,
            'email'    => 'siswa@fella.id',
            'password' => Hash::make('password'),
            'role'     => 'siswa',
            'siswa_id' => $siswaModels[0]->id,
        ]);

        // ── 4. Jadwal ────────────────────────────────────────────────
        $jadwalData = [
            ['siswa_id' => $siswaModels[0]->id, 'pelatih_id' => $pelatih1->id, 'hari' => 'Senin',  'jam' => '06:00', 'lokasi' => LokasiLes::ISTANA_MENTARI->value, 'durasi' => '60 Menit',  'tipe' => 'reguler'],
            ['siswa_id' => $siswaModels[1]->id, 'pelatih_id' => $pelatih2->id, 'hari' => 'Selasa', 'jam' => '07:00', 'lokasi' => LokasiLes::HOTEL_ASTON->value,    'durasi' => '90 Menit',  'tipe' => 'reguler'],
            ['siswa_id' => $siswaModels[2]->id, 'pelatih_id' => $pelatih2->id, 'hari' => 'Rabu',   'jam' => '15:00', 'lokasi' => LokasiLes::HOTEL_SWISS_BERLINN->value, 'durasi' => '60 Menit', 'tipe' => 'reguler'],
            ['siswa_id' => $siswaModels[3]->id, 'pelatih_id' => $pelatih1->id, 'hari' => 'Kamis',  'jam' => '06:00', 'lokasi' => LokasiLes::ISTANA_MENTARI->value, 'durasi' => '60 Menit',  'tipe' => 'reguler'],
            ['siswa_id' => $siswaModels[4]->id, 'pelatih_id' => $pelatih1->id, 'hari' => 'Jumat',  'jam' => '07:00', 'lokasi' => LokasiLes::REGENCY_21->value,     'durasi' => '120 Menit', 'tipe' => 'reguler'],
            ['siswa_id' => $siswaModels[0]->id, 'pelatih_id' => $pelatih2->id, 'hari' => 'Sabtu',  'jam' => '08:00', 'lokasi' => LokasiLes::HOTEL_ASTON->value,    'durasi' => '90 Menit',  'tipe' => 'backup'],
            ['siswa_id' => $siswaModels[1]->id, 'pelatih_id' => $pelatih1->id, 'hari' => 'Minggu', 'jam' => '09:00', 'lokasi' => LokasiLes::REGENCY_21->value,     'durasi' => '60 Menit',  'tipe' => 'backup'],
        ];

        $jadwalModels = [];
        foreach ($jadwalData as $data) {
            $jadwalModels[] = Jadwal::create($data);
        }

        // ── 5. Presensi (beberapa record contoh) ─────────────────────
        // Observer akan menghitung sesi_terpakai secara otomatis JIKA fresh seed.
        // Karena siswa sudah punya sesi_terpakai dari data awal, kita skip observer di sini.
        // Data presensi dibuat langsung pakai insertOrIgnore tanpa memicu observer:
        $today = now();
        $presensiBatch = [];
        for ($i = 1; $i <= 5; $i++) {
            $presensiBatch[] = [
                'jadwal_id'  => $jadwalModels[0]->id,
                'siswa_id'   => $siswaModels[0]->id,
                'pelatih_id' => $pelatih1->id,
                'tanggal'    => $today->copy()->subWeeks($i)->toDateString(),
                'status'     => 'hadir',
                'catatan'    => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        \App\Models\Presensi::insert($presensiBatch);
    }
}
