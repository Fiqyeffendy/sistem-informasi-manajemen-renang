<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'siswa_id',
        'pelatih_id',
        'hari',
        'jam',
        'lokasi',
        'status',
        'durasi',
        'tipe',
    ];

    protected $casts = [
        'siswa_id'   => 'string',
        'pelatih_id' => 'string',
    ];

    // Relationships
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pelatih(): BelongsTo
    {
        return $this->belongsTo(Pelatih::class, 'pelatih_id');
    }

    public function presensis(): HasMany
    {
        return $this->hasMany(Presensi::class, 'jadwal_id');
    }
}
