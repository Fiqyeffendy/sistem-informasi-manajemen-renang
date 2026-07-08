<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PendaftaranApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_pendaftaran_saves_program_fields(): void
    {
        $payload = [
            'tipe_pendaftar' => 'wali',
            'nama_lengkap' => 'Budi Santoso',
            'nama_panggilan' => 'Budi',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2015-01-10',
            'no_whatsapp' => '081234567890',
            'nama_wali' => 'Sari',
            'hubungan_wali' => 'Ibu',
            'no_hp_wali' => '081234567891',
            'alamat' => 'Jl. Merdeka 12',
            'program' => 'Fella SwimStars (Swimming Lessons for Kids)',
            'jenis_program' => 'Group',
            'lokasi_les' => 'Hotel Aston Sidoarjo',
            'instagram' => '@budi',
            'catatan' => 'Coba dulu',
            'email' => 'budi@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->postJson('/api/pendaftaran', $payload);

        $response->assertCreated();
        $response->assertJsonPath('program', $payload['program']);
        $response->assertJsonPath('jenis_program', $payload['jenis_program']);
        $response->assertJsonPath('lokasi_les', $payload['lokasi_les']);
        $this->assertDatabaseHas('pendaftaran', [
            'nama_lengkap' => 'Budi Santoso',
            'program' => $payload['program'],
            'jenis_program' => $payload['jenis_program'],
            'lokasi_les' => $payload['lokasi_les'],
        ]);
    }

    public function test_store_pendaftaran_creates_login_account_for_student(): void
    {
        $payload = [
            'tipe_pendaftar' => 'wali',
            'nama_lengkap' => 'Nina Putri',
            'nama_panggilan' => 'Nina',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Bandung',
            'tanggal_lahir' => '2014-02-14',
            'no_whatsapp' => '081122334455',
            'nama_wali' => 'Dewi',
            'hubungan_wali' => 'Ibu',
            'no_hp_wali' => '081122334456',
            'alamat' => 'Jl. Melati 10',
            'email' => 'nina@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->postJson('/api/pendaftaran', $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => 'nina@example.com',
            'role' => 'siswa',
        ]);

        $user = User::where('email', 'nina@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('Password123!', $user->password));
    }

    public function test_store_pendaftaran_for_self_ignores_wali_fields(): void
    {
        $payload = [
            'tipe_pendaftar' => 'self',
            'nama_lengkap' => 'Rian Hidayat',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '1998-05-15',
            'no_whatsapp' => '081223344556',
            'alamat' => 'Jl. Gubeng 25',
            'email' => 'rian@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ];

        $response = $this->postJson('/api/pendaftaran', $payload);

        $response->assertCreated();
        $this->assertDatabaseHas('pendaftaran', [
            'nama_lengkap' => 'Rian Hidayat',
            'tipe_pendaftar' => 'self',
            'nama_wali' => 'Rian Hidayat',
            'hubungan_wali' => 'Diri Sendiri',
        ]);
    }
}
