<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Pelatih;
use App\Models\Pendaftaran;
use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    // Dashboard admin memuat ringkasan utama sistem untuk mengawasi siswa, pelatih, jadwal, dan presensi.
    public function dashboard()
    {
        $totalSiswa = Siswa::count();
        $totalPelatih = Pelatih::count();
        $totalJadwal = Jadwal::count();
        
        // Hitung kelas yang berstatus aktif.
        $activeKelas = Jadwal::where('status', 'aktif')->count();

        // Ambil data pendaftaran terbaru untuk ringkasan.
        $latestPendaftarans = Pendaftaran::orderByDesc('tanggal_daftar')->take(5)->get();

        // Hitung pendaftaran yang masih pending.
        $pendingPendaftaranCount = Pendaftaran::where('status', 'pending')->count();

        // Ambil riwayat presensi terbaru beserta relasi siswa/pelatih/jadwal.
        $latestPresensis = Presensi::with(['siswa', 'pelatih', 'jadwal'])
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Tentukan hari ini dalam nama bahasa Indonesia.
        $indonesianDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $todayIndonesian = $indonesianDays[now()->dayOfWeek];
        
        // Ambil jadwal aktif yang cocok dengan hari ini.
        $todayJadwals = Jadwal::with(['siswa', 'pelatih'])
            ->where('hari', $todayIndonesian)
            ->where('status', 'aktif')
            ->orderBy('jam')
            ->get();

        // Hitung berapa presensi hadir hari ini.
        $todayPresensiCount = Presensi::where('tanggal', now()->toDateString())
            ->where('status', 'hadir')
            ->count();

        // Ambil data pelatih dengan jumlah siswa unik dan total sesi.
        $coaches = Pelatih::withCount([
            'jadwals as total_siswa' => function ($q) {
                $q->select(DB::raw('count(distinct(siswa_id))'));
            },
            'jadwals as total_sesi'
        ])->get();

        // Hitung jumlah sesi aktif per hari untuk chart.
        $schedulesPerDay = DB::table('jadwal')
            ->where('status', 'aktif')
            ->select('hari', DB::raw('count(*) as count'))
            ->groupBy('hari')
            ->pluck('count', 'hari')
            ->toArray();

        $daysOfWeek = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $sesiChartData = [];
        foreach ($daysOfWeek as $day) {
            $sesiChartData[$day] = $schedulesPerDay[$day] ?? 0;
        }

        // Ambil data tren kehadiran selama 8 minggu terakhir.
        $weeksData = [];
        $weeksLabel = [];
        for ($i = 7; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end = now()->subWeeks($i)->endOfWeek();

            $count = Presensi::whereBetween('tanggal', [$start, $end])
                ->where('status', 'hadir')
                ->count();

            $weeksData[] = $count;
            $weeksLabel[] = 'W' . (8 - $i);
        }

        // Buat path SVG untuk chart area di frontend.
        $points = [];
        foreach ($weeksData as $index => $value) {
            $x = 40 + ($index * 60);
            $y = 160 - min(120, $value * 2);
            $points[] = "$x $y";
        }
        $pathD = "M " . implode(" L ", $points);
        $areaD = "M 40 160 L " . implode(" L ", $points) . " L 460 160 Z";

        // Kirim semua variabel ke view admin.dashboard.
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPelatih',
            'totalJadwal',
            'activeKelas',
            'latestPendaftarans',
            'pendingPendaftaranCount',
            'latestPresensis',
            'todayJadwals',
            'todayIndonesian',
            'todayPresensiCount',
            'coaches',
            'sesiChartData',
            'weeksData',
            'weeksLabel',
            'pathD',
            'areaD'
        ));
    }

    // Halaman presensi admin menampilkan semua riwayat absensi dengan relasi nama yang lengkap.
    public function presensi()
    {
        $presensis = Presensi::with(['siswa', 'pelatih', 'jadwal'])
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.presensi', compact('presensis'));
    }

    // Halaman sesi admin memberikan rekap jadwal per hari berdasarkan status aktif atau tidak aktif.
    public function sesi()
    {
        $siswas = Siswa::orderBy('nama')->get();

        $rekapHari = DB::table('jadwal')
            ->select('hari', DB::raw('count(*) as total'), DB::raw("sum(case when status = 'aktif' then 1 else 0 end) as aktif"), DB::raw("sum(case when status = 'tidak_aktif' then 1 else 0 end) as tidak_aktif"))
            ->groupBy('hari')
            ->get();

        return view('admin.sesi', compact('siswas', 'rekapHari'));
    }

    // Laporan admin memfilter data presensi berdasarkan periode dan status lalu merangkum hasilnya.
    public function laporan(Request $request)
    {
        $periode = $request->input('periode', 'minggu');
        $status = $request->input('status', 'all');

        $query = Presensi::with(['siswa', 'pelatih', 'jadwal']);

        if ($periode === 'minggu') {
            $query->where('tanggal', '>=', now()->startOfWeek());
        } elseif ($periode === 'bulan') {
            $query->where('tanggal', '>=', now()->startOfMonth());
        } elseif ($periode === 'tahun') {
            $query->where('tanggal', '>=', now()->startOfYear());
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $presensis = $query->orderByDesc('tanggal')->get();

        $totalJadwal = Jadwal::count();
        $totalPresensi = Presensi::count();
        $hadirCount = Presensi::where('status', 'hadir')->count();
        $izinCount = Presensi::where('status', 'izin')->count();
        $alphaCount = Presensi::where('status', 'alpha')->count();

        $rekapSiswa = Siswa::withCount([
            'presensis as total_hadir' => function ($q) { $q->where('status', 'hadir'); },
            'presensis as total_izin' => function ($q) { $q->where('status', 'izin'); },
            'presensis as total_alpha' => function ($q) { $q->where('status', 'alpha'); },
        ])->get();

        return view('admin.laporan', compact(
            'presensis',
            'periode',
            'status',
            'totalJadwal',
            'totalPresensi',
            'hadirCount',
            'izinCount',
            'alphaCount',
            'rekapSiswa'
        ));
    }
}
