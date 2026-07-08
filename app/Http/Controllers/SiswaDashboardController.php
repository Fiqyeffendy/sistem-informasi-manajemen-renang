<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    // Dashboard siswa menampilkan jadwal dan riwayat absensi berdasarkan akun siswa yang login.
    public function dashboard()
    {
        $user = Auth::user();
        $siswa = $user?->siswa;

        $jadwals = Jadwal::with('pelatih')
            ->where('siswa_id', $siswa?->id)
            ->orderBy('hari')
            ->get();

        $presensis = Presensi::with(['jadwal', 'pelatih'])
            ->where('siswa_id', $siswa?->id)
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('user', 'siswa', 'jadwals', 'presensis'));
    }

    // Halaman jadwal siswa menampilkan seluruh sesi latihan yang dimiliki siswa tersebut.
    public function jadwal()
    {
        $user = Auth::user();
        $siswa = $user?->siswa;

        $jadwals = Jadwal::with('pelatih')
            ->where('siswa_id', $siswa?->id)
            ->orderBy('hari')
            ->get();

        return view('siswa.jadwal', compact('user', 'siswa', 'jadwals'));
    }

    // Halaman riwayat presensi siswa menampilkan semua catatan absensi yang pernah dibuat.
    public function presensi()
    {
        $user = Auth::user();
        $siswa = $user?->siswa;

        $presensis = Presensi::with(['jadwal.pelatih', 'pelatih'])
            ->where('siswa_id', $siswa?->id)
            ->orderByDesc('tanggal')
            ->get();

        return view('siswa.presensi', compact('user', 'siswa', 'presensis'));
    }

    // Halaman sesi siswa menampilkan ringkasan kuota latihan dan detail program yang aktif.
    public function sesi()
    {
        $user = Auth::user();
        $siswa = $user?->siswa;

        $jadwals = Jadwal::with('pelatih')
            ->where('siswa_id', $siswa?->id)
            ->get();

        return view('siswa.sesi', compact('user', 'siswa', 'jadwals'));
    }
}
