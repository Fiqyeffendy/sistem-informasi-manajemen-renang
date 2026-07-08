<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelatih extends Model
{
    // Model ini menyimpan profil pelatih dan relasi jadwal serta presensi mereka.
    protected $table = 'pelatih';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nama',
        'no_hp',
        'email',
        'spesialisasi',
        'jadwal_mengajar',
        'status',
        'alasan_cuti',
    ];

    protected static function booted()
    {
        static::creating(function ($pelatih) {
            if (empty($pelatih->id)) {
                // Get the last record sorted by parsing the numeric part of the ID string
                $lastPelatih = Pelatih::orderByRaw("CAST(SUBSTRING(id, 2) AS INTEGER) DESC")->first();
                if ($lastPelatih) {
                    $lastNum = (int) substr($lastPelatih->id, 1);
                    $nextNum = $lastNum + 1;
                } else {
                    $nextNum = 1;
                }
                $pelatih->id = 'P' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
            }
        });
    }

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
