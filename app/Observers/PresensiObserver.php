<?php

namespace App\Observers;

use App\Models\Presensi;

class PresensiObserver
{
    /**
     * Ketika presensi baru dibuat:
     * - Jika status hadir → increment sesi_terpakai siswa.
     */
    public function created(Presensi $presensi): void
    {
        if ($presensi->status === 'hadir') {
            $presensi->siswa()->increment('sesi_terpakai');
        }
    }

    /**
     * Ketika presensi diupdate:
     * - Jika status berubah dari bukan-hadir → hadir, increment sesi.
     * - Jika status berubah dari hadir → bukan-hadir, decrement sesi.
     */
    public function updated(Presensi $presensi): void
    {
        $oldStatus = $presensi->getOriginal('status');
        $newStatus = $presensi->status;

        if ($oldStatus !== 'hadir' && $newStatus === 'hadir') {
            $presensi->siswa()->increment('sesi_terpakai');
        } elseif ($oldStatus === 'hadir' && $newStatus !== 'hadir') {
            $presensi->siswa()->decrement('sesi_terpakai');
        }
    }

    /**
     * Ketika presensi dihapus:
     * - Jika statusnya hadir, decrement sesi_terpakai siswa.
     */
    public function deleted(Presensi $presensi): void
    {
        if ($presensi->status === 'hadir') {
            $presensi->siswa()->decrement('sesi_terpakai');
        }
    }
}
