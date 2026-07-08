<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Presensi extends Model
{
    // Model ini merekam status hadir, izin, atau alpha untuk setiap jadwal siswa.
    protected $table = 'presensi';

    protected $fillable = [
        'jadwal_id',
        'siswa_id',
        'pelatih_id',
        'tanggal',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal'    => 'date',
        'jadwal_id'  => 'integer',
        'siswa_id'   => 'string',
        'pelatih_id' => 'string',
    ];

    // Relationships
    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class, 'jadwal_id');
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function pelatih(): BelongsTo
    {
        return $this->belongsTo(Pelatih::class, 'pelatih_id');
    }
}
