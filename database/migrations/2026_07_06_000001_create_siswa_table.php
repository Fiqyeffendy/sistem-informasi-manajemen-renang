<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabel siswa menyimpan data utama murid beserta paket sesi dan status akun.
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('nama');
            $table->integer('umur')->nullable();
            $table->string('no_hp_ortu', 50)->nullable();
            $table->string('program');
            $table->string('jenis_program');
            $table->string('lokasi_les');
            $table->integer('total_sesi')->default(4);
            $table->integer('sesi_terpakai')->default(0);
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
