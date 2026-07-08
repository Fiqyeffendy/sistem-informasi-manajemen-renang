<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabel presensi mencatat status kehadiran setiap siswa pada jadwal tertentu.
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_id')->constrained('jadwal')->cascadeOnDelete();
            $table->string('siswa_id', 50);
            $table->foreign('siswa_id')->references('id')->on('siswa')->cascadeOnDelete();
            $table->string('pelatih_id', 50);
            $table->foreign('pelatih_id')->references('id')->on('pelatih')->cascadeOnDelete();
            $table->date('tanggal');
            $table->enum('status', ['hadir', 'izin', 'alpha'])->default('hadir');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Tidak boleh input presensi yang sama (siswa + jadwal + tanggal)
            $table->unique(['siswa_id', 'jadwal_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
