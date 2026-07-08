<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Tabel ini menyimpan form pendaftaran siswa sebelum data siswa resmi dibuat.
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pendaftaran')->unique();
            $table->string('nama_lengkap');
            $table->string('nama_panggilan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('no_whatsapp', 50);
            $table->string('nama_wali')->nullable();
            $table->string('hubungan_wali', 100)->nullable();
            $table->string('no_hp_wali', 50)->nullable();
            $table->text('alamat');
            $table->string('instagram')->nullable();
            $table->text('catatan')->nullable();
            $table->string('program')->nullable();
            $table->string('jenis_program')->nullable();
            $table->string('lokasi_les')->nullable();
            $table->enum('tipe_pendaftar', ['self', 'wali'])->default('wali');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamp('tanggal_daftar')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('siswa_id', 50)->nullable();
            $table->foreign('siswa_id')->references('id')->on('siswa')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
