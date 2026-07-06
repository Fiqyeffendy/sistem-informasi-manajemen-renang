<?php

namespace App\Models;

use App\Enums\JenisProgram;
use App\Enums\LokasiLes;
use App\Enums\Program;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama',
        'umur',
        'no_hp_ortu',
        'program',
        'jenis_program',
        'lokasi_les',
        'total_sesi',
        'sesi_terpakai',
        'status',
    ];

    protected $casts = [
        'umur'          => 'integer',
        'total_sesi'    => 'integer',
        'sesi_terpakai' => 'integer',
        'program'       => Program::class,
        'jenis_program' => JenisProgram::class,
        'lokasi_les'    => LokasiLes::class,
    ];

    // Computed attribute: sisa sesi
    public function getSisaSesiAttribute(): int
    {
        return max(0, $this->total_sesi - $this->sesi_terpakai);
    }

    // Relationships
    public function pendaftarans(): HasMany
    {
        return $this->hasMany(Pendaftaran::class, 'siswa_id');
    }

    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'siswa_id');
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class, 'siswa_id');
    }
}