<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendaftaranApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_pendaftaran_saves_program_fields(): void
    {
        $payload = [
            'nama_lengkap' => 'Budi Santoso',
            'nama_panggilan' => 'Budi',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2015-01-10',
            'no_whatsapp' => '081234567890',
            'nama_wali' => 'Sari',
            'hubungan_wali' => 'Ibu',
            'alamat' => 'Jl. Merdeka 12',
            'program' => 'Fella SwimStars (Swimming Lessons for Kids)',
            'jenis_program' => 'Group',
            'lokasi_les' => 'Hotel Aston Sidoarjo',
            'instagram' => '@budi',
            'catatan' => 'Coba dulu',
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
}
