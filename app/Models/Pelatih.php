<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelatih extends Model
{
    protected $table = 'pelatih';

    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'spesialisasi',
        'jadwal_mengajar',
        'status',
        'alasan_cuti',
    ];

    protected $casts = [
        'spesialisasi'    => 'array',
        'jadwal_mengajar' => 'array',
    ];

    // Relationships
    public function jadwals(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'pelatih_id');
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class, 'pelatih_id');
    }
}
