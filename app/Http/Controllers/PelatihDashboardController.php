<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihDashboardController extends Controller
{
    // Ambil profil pelatih yang sedang login agar halaman hanya bisa diakses oleh akun yang valid.
    private function getPelatih()
    {
        $user = Auth::user();
        $pelatih = $user?->pelatih;
        
        if (!$pelatih) {
            abort(403, 'Akses ditolak. Profil pelatih tidak ditemukan.');
        }
        
        return $pelatih;
    }

    // Dashboard pelatih menampilkan ringkasan siswa, jadwal, dan presensi yang terkait dengan akun pelatih.
    public function dashboard()
    {
        $user = Auth::user();
        $pelatih = $this->getPelatih();

        $siswaIds = Jadwal::where('pelatih_id', $pelatih->id)->pluck('siswa_id')->unique();
        $totalSiswa = Siswa::whereIn('id', $siswaIds)->count();
        $totalJadwal = Jadwal::where('pelatih_id', $pelatih->id)->count();
        $totalPresensi = Presensi::where('pelatih_id', $pelatih->id)->count();

        $jadwals = Jadwal::with('siswa')
            ->where('pelatih_id', $pelatih->id)
            ->where('tipe', 'reguler')
            ->orderBy('hari')
            ->orderBy('jam')
            ->take(5)
            ->get();

        return view('pelatih.dashboard', compact('user', 'pelatih', 'totalSiswa', 'totalJadwal', 'totalPresensi', 'jadwals'));
    }

    // Halaman siswa pelatih menampilkan daftar siswa yang terhubung dengan jadwal pelatih tersebut.
    public function siswa()
    {
        $user = Auth::user();
        $pelatih = $this->getPelatih();

        $siswaIds = Jadwal::where('pelatih_id', $pelatih->id)->pluck('siswa_id')->unique();
        $siswas = Siswa::whereIn('id', $siswaIds)->get();

        return view('pelatih.siswa', compact('user', 'pelatih', 'siswas'));
    }

    // Halaman jadwal pelatih menampilkan seluruh jadwal yang dia kelola beserta siswa yang terkait.
    public function jadwal()
    {
        $user = Auth::user();
        $pelatih = $this->getPelatih();

        $jadwals = Jadwal::with('siswa')
            ->where('pelatih_id', $pelatih->id)
            ->orderBy('hari')
            ->orderBy('jam')
            ->get();

        return view('pelatih.jadwal', compact('user', 'pelatih', 'jadwals'));
    }

    // Halaman presensi pelatih menampilkan riwayat absensi dan daftar jadwal aktif untuk pencatatan baru.
    public function presensi()
    {
        $user = Auth::user();
        $pelatih = $this->getPelatih();

        $presensis = Presensi::with(['siswa', 'jadwal'])
            ->where('pelatih_id', $pelatih->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->get();

        $siswaIds = Jadwal::where('pelatih_id', $pelatih->id)->pluck('siswa_id')->unique();
        $siswas = Siswa::whereIn('id', $siswaIds)->get();

        $jadwals = Jadwal::with('siswa')
            ->where('pelatih_id', $pelatih->id)
            ->where('status', 'aktif')
            ->orderBy('hari')
            ->orderBy('jam')
            ->get();

        return view('pelatih.presensi', compact('user', 'pelatih', 'presensis', 'siswas', 'jadwals'));
    }

    // Simpan absensi baru dari form pelatih setelah validasi dan cek duplikasi harian.
    public function storePresensi(Request $request)
    {
        $pelatih = $this->getPelatih();

        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'siswa_id' => 'required|exists:siswa,id',
            'status' => 'required|in:hadir,izin,alpha',
            'catatan' => 'nullable|string|max:500',
        ]);

        $validated['pelatih_id'] = $pelatih->id;
        $validated['tanggal'] = now()->toDateString();

        $exists = Presensi::where('jadwal_id', $validated['jadwal_id'])
            ->where('siswa_id', $validated['siswa_id'])
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Presensi untuk siswa ini pada jadwal tersebut hari ini sudah pernah dicatat.');
        }

        Presensi::create($validated);

        return back()->with('success', 'Presensi berhasil disimpan.');
    }

    // Hapus absensi yang hanya boleh dihapus oleh pelatih pemilik data.
    public function destroyPresensi($id)
    {
        $pelatih = $this->getPelatih();
        
        $presensi = Presensi::where('id', $id)
            ->where('pelatih_id', $pelatih->id)
            ->firstOrFail();

        $presensi->delete();

        return back()->with('success', 'Presensi berhasil dihapus.');
    }
}
