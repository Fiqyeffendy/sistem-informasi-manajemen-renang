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
            $table->foreignId('pelatih_id')->nullable()->constrained('pelatih')->nullOnDelete()->after('role');
            $table->foreignId('siswa_id')->nullable()->constrained('siswa')->nullOnDelete()->after('pelatih_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('pelatih_id');
            $table->dropConstrainedForeignId('siswa_id');
            $table->dropColumn('role');
        });
    }
};
