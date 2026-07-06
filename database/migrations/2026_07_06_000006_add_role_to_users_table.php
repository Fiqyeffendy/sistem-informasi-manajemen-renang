<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pelatih', 'siswa'])->default('siswa')->after('email');
            $table->string('pelatih_id', 50)->nullable()->after('role');
            $table->foreign('pelatih_id')->references('id')->on('pelatih')->nullOnDelete();
            $table->string('siswa_id', 50)->nullable()->after('pelatih_id');
            $table->foreign('siswa_id')->references('id')->on('siswa')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['pelatih_id']);
            $table->dropColumn('pelatih_id');
            $table->dropForeign(['siswa_id']);
            $table->dropColumn('siswa_id');
            $table->dropColumn('role');
        });
    }
};
