<?php

namespace Tests\Feature;

use Tests\TestCase;

class ModuleUiTest extends TestCase
{
    public function test_admin_siswa_page_redirects_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/admin/siswa');

        $response->assertRedirect('/login');
    }

    public function test_admin_pelatih_and_jadwal_pages_redirect_unauthenticated_users_to_login(): void
    {
        $response = $this->get('/admin/pelatih');

        $response->assertRedirect('/login');

        $jadwalResponse = $this->get('/admin/jadwal');
        $jadwalResponse->assertRedirect('/login');
    }
}
