<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'kode_pendaftaran',
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_whatsapp',
        'nama_wali',
        'hubungan_wali',
        'alamat',
        'instagram',
        'catatan',
        'program',
        'jenis_program',
        'lokasi_les',
        'status',
        'tanggal_daftar',
        'verified_by',
        'verified_at',
        'siswa_id',
    ];

    protected $casts = [
        'tanggal_lahir'  => 'date',
        'tanggal_daftar' => 'datetime',
        'verified_at'    => 'datetime',
        'siswa_id'       => 'string',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
