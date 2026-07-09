<?php

namespace Tests\Feature;

use App\Models\Pelatih;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private Siswa $siswa;
    private Pelatih $pelatih;
    private Jadwal $jadwal;
    private Presensi $presensi;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'name' => 'Admin Fella',
            'email' => 'admin@fella.id',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->pelatih = Pelatih::create([
            'nama' => 'Coach Rizal',
            'no_hp' => '081234560001',
            'email' => 'rizal@fella.id',
            'spesialisasi' => ['Kids'],
            'jadwal_mengajar' => ['Senin' => '08:00'],
            'status' => 'aktif',
        ]);

        $this->siswa = Siswa::create([
            'nama' => 'Ahmad Fauzi',
            'umur' => 12,
            'no_hp_ortu' => '08122334455',
            'program' => 'Fella SwimStars (Swimming Lessons for Kids)',
            'jenis_program' => 'Group',
            'lokasi_les' => 'Perumahan Istana Mentari',
            'total_sesi' => 10,
            'sesi_terpakai' => 2,
            'status' => 'aktif',
        ]);

        $this->jadwal = Jadwal::create([
            'siswa_id' => $this->siswa->id,
            'pelatih_id' => $this->pelatih->id,
            'hari' => 'Senin',
            'jam' => '08:00',
            'lokasi' => 'Perumahan Istana Mentari',
            'durasi' => '60 Menit',
            'tipe' => 'reguler',
            'status' => 'aktif',
        ]);

        $this->presensi = Presensi::create([
            'jadwal_id' => $this->jadwal->id,
            'siswa_id' => $this->siswa->id,
            'pelatih_id' => $this->pelatih->id,
            'tanggal' => now()->toDateString(),
            'status' => 'hadir',
            'catatan' => 'Hadir tepat waktu',
        ]);
    }

    public function test_admin_can_access_dashboard_with_all_dynamic_counters(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/dashboard');

        $response->assertOk();
        $response->assertSee('Admin');
        $response->assertSee('Jadwal Hari Ini');
        $response->assertSee('Ahmad Fauzi');
    }

    public function test_admin_can_access_presensi_history_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/presensi');

        $response->assertOk();
        $response->assertSee('Ahmad Fauzi');
        $response->assertSee('Hadir');
    }

    public function test_admin_can_access_sesi_balance_page(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/admin/sesi');

        $response->assertOk();
        $response->assertSee('Ahmad Fauzi');
        $response->assertSee('7 sesi'); // 10 - (2 + 1 from presensi)
    }

    public function test_admin_can_access_laporan_page_with_filters(): void
    {
        // 1. Access default
        $response = $this->actingAs($this->adminUser)->get('/admin/laporan');
        $response->assertOk();
        $response->assertSee('Ringkasan Laporan');
        $response->assertSee('Ahmad Fauzi');

        // 2. Access with specific filter
        $responseFiltered = $this->actingAs($this->adminUser)->get('/admin/laporan?periode=bulan&status=hadir');
        $responseFiltered->assertOk();
    }

    public function test_non_admin_cannot_access_admin_pages(): void
    {
        $studentUser = User::create([
            'name' => 'General Student',
            'email' => 'student@fella.id',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $response = $this->actingAs($studentUser)->get('/admin/dashboard');
        $response->assertForbidden();
    }

    public function test_admin_can_access_view_only_pages(): void
    {
        $this->actingAs($this->adminUser)->get('/admin/siswa')->assertOk();
        $this->actingAs($this->adminUser)->get('/admin/pendaftaran')->assertOk();
        $this->actingAs($this->adminUser)->get('/admin/pelatih')->assertOk();
        $this->actingAs($this->adminUser)->get('/admin/jadwal')->assertOk();
    }
}
