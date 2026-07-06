<?php

namespace Tests\Feature;

use Tests\TestCase;

class ModuleUiTest extends TestCase
{
    public function test_admin_siswa_page_exposes_modal_inputs_and_save_action(): void
    {
        $response = $this->get('/admin/siswa');

        $response->assertStatus(200);
        $response->assertSee('id="siswa-nama"', false);
        $response->assertSee('id="siswa-umur"', false);
        $response->assertSee('id="siswa-paket"', false);
        $response->assertSee('id="siswa-no-hp"', false);
        $response->assertSee('data-action="save-siswa"', false);
    }

    public function test_admin_pelatih_and_jadwal_pages_expose_modal_forms_and_actions(): void
    {
        $response = $this->get('/admin/pelatih');

        $response->assertStatus(200);
        $response->assertSee('id="pelatih-nama"', false);
        $response->assertSee('id="pelatih-no-hp"', false);
        $response->assertSee('id="spesial-add-toddler"', false);
        $response->assertSee('data-action="save-pelatih"', false);

        $jadwalResponse = $this->get('/admin/jadwal');
        $jadwalResponse->assertStatus(200);
        $jadwalResponse->assertSee('id="jadwal-hari"', false);
        $jadwalResponse->assertSee('id="jadwal-jam"', false);
        $jadwalResponse->assertSee('id="jadwal-lokasi"', false);
        $jadwalResponse->assertSee('id="jadwal-durasi"', false);
        $jadwalResponse->assertSee('data-action="save-jadwal"', false);
    }
}
