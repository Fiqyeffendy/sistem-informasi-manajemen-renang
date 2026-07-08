<?php

namespace Tests\Feature;

use App\Enums\JenisProgram;
use App\Enums\LokasiLes;
use App\Enums\Program;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_shows_authenticated_user_profile_data(): void
    {
        $siswa = Siswa::create([
            'nama' => 'Budi Santoso',
            'umur' => 10,
            'no_hp_ortu' => '081234567890',
            'program' => Program::SWIM_STARS->value,
            'jenis_program' => JenisProgram::GROUP->value,
            'lokasi_les' => LokasiLes::HOTEL_ASTON->value,
            'total_sesi' => 8,
            'sesi_terpakai' => 2,
            'status' => 'aktif',
        ]);

        $user = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
            'siswa_id' => $siswa->id,
        ]);

        $response = $this->actingAs($user)->get('/siswa/dashboard');

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertSee('Fella SwimStars');
    }
}
