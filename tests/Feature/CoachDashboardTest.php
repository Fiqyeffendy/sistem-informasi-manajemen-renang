<?php

namespace Tests\Feature;

use App\Models\Pelatih;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CoachDashboardTest extends TestCase
{
    use RefreshDatabase;

    private User $coachUser;
    private Pelatih $pelatih;
    private Siswa $siswa;
    private Jadwal $jadwal;

    protected function setUp(): void
    {
        parent::setUp();

        $this->pelatih = Pelatih::create([
            'nama' => 'Coach Rizal',
            'no_hp' => '081234560001',
            'email' => 'rizal@fella.id',
            'spesialisasi' => ['Kids', 'Adults'],
            'jadwal_mengajar' => ['Senin' => '08:00'],
            'status' => 'aktif',
        ]);

        $this->coachUser = User::create([
            'name' => 'Coach Rizal',
            'email' => 'rizal@fella.id',
            'password' => bcrypt('password'),
            'role' => 'pelatih',
            'pelatih_id' => $this->pelatih->id,
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
    }

    public function test_coach_can_access_dashboard_with_kpi_metrics(): void
    {
        $response = $this->actingAs($this->coachUser)->get('/pelatih/dashboard');

        $response->assertOk();
        $response->assertSee('Coach Rizal');
        $response->assertSee('Total Siswa Aktif');
        $response->assertSee('Jadwal Mengajar');
    }

    public function test_coach_can_view_assigned_students(): void
    {
        $response = $this->actingAs($this->coachUser)->get('/pelatih/siswa');

        $response->assertOk();
        $response->assertSee('Ahmad Fauzi');
    }

    public function test_coach_can_view_schedules(): void
    {
        $response = $this->actingAs($this->coachUser)->get('/pelatih/jadwal');

        $response->assertOk();
        $response->assertSee('Senin');
        $response->assertSee('08:00');
    }

    public function test_coach_can_manage_presensi(): void
    {
        // 1. View presensi page
        $response = $this->actingAs($this->coachUser)->get('/pelatih/presensi');
        $response->assertOk();

        // 2. Submit new attendance (Hadir)
        $postResponse = $this->actingAs($this->coachUser)->post('/pelatih/presensi', [
            'jadwal_id' => $this->jadwal->id,
            'siswa_id' => $this->siswa->id,
            'status' => 'hadir',
            'catatan' => 'Datang tepat waktu',
        ]);

        $postResponse->assertRedirect();
        
        // Assert record created in database
        $this->assertDatabaseHas('presensi', [
            'jadwal_id' => $this->jadwal->id,
            'siswa_id' => $this->siswa->id,
            'status' => 'hadir',
        ]);

        // Assert observer automatically incremented the student's sesi_terpakai (from 2 to 3)
        $this->siswa->refresh();
        $this->assertEquals(3, $this->siswa->sesi_terpakai);

        // 3. Delete attendance
        $presensi = Presensi::first();
        $deleteResponse = $this->actingAs($this->coachUser)->delete('/pelatih/presensi/' . $presensi->id);
        $deleteResponse->assertRedirect();

        // Assert record deleted
        $this->assertDatabaseMissing('presensi', ['id' => $presensi->id]);

        // Assert observer automatically decremented sesi_terpakai back to 2
        $this->siswa->refresh();
        $this->assertEquals(2, $this->siswa->sesi_terpakai);
    }

    public function test_non_coach_cannot_access_coach_pages(): void
    {
        $guestUser = User::create([
            'name' => 'General Student',
            'email' => 'student@fella.id',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);

        $response = $this->actingAs($guestUser)->get('/pelatih/dashboard');
        // Role middleware aborts with 403 Forbidden
        $response->assertForbidden();
    }
}
