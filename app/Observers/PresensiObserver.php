<?php

namespace App\Observers;

use App\Models\Presensi;

class PresensiObserver
{
    // Saat presensi hadir dibuat, sesi siswa otomatis bertambah.
    public function created(Presensi $presensi): void
    {
        // Saat presensi hadir dibuat, tambahkan satu sesi terpakai untuk siswa.
        if ($presensi->status === 'hadir') {
            $presensi->siswa()->increment('sesi_terpakai');
        }
    }

    // Saat status presensi berubah, saldo sesi siswa ikut disesuaikan.
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

    // Saat presensi dihapus, sesi yang sebelumnya tercatat dikurangi kembali.
    public function deleted(Presensi $presensi): void
    {
        if ($presensi->status === 'hadir') {
            $presensi->siswa()->decrement('sesi_terpakai');
        }
    }
}
