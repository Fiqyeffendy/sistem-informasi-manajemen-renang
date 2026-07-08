<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabel jadwal menghubungkan siswa, pelatih, hari, dan jam latihan.
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->string('siswa_id', 50);
            $table->foreign('siswa_id')->references('id')->on('siswa')->cascadeOnDelete();
            $table->string('pelatih_id', 50);
            $table->foreign('pelatih_id')->references('id')->on('pelatih')->cascadeOnDelete();
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
            $table->time('jam');
            $table->string('lokasi');
            $table->enum('status', ['aktif', 'tidak_aktif', 'libur'])->default('aktif');
            $table->string('durasi')->default('60 Menit');
            $table->enum('tipe', ['reguler', 'backup'])->default('reguler');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
