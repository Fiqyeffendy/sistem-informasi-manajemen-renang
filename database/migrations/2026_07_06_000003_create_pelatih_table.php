<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelatih', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_hp', 50)->nullable();
            $table->string('email')->unique()->nullable();
            $table->json('spesialisasi')->nullable();
            $table->json('jadwal_mengajar')->nullable(); // [{hari: "Senin", jam: "08:00"}, ...]
            $table->enum('status', ['aktif', 'cuti'])->default('aktif');
            $table->text('alasan_cuti')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelatih');
    }
};
