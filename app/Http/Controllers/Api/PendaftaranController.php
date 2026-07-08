<?php

namespace App\Http\Controllers\Api;

use App\Enums\JenisProgram;
use App\Enums\LokasiLes;
use App\Enums\Program;
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PendaftaranController extends Controller
{
    // GET /api/pendaftaran - Ambil semua pendaftaran.
    // Digunakan untuk halaman admin/pendaftaran dan laporan.
    public function index()
    {
        return response()->json(Pendaftaran::orderBy('created_at', 'desc')->get(), 200);
    }

    // POST /api/pendaftaran - Simpan pendaftaran baru.
    // Jika email tidak dikirim, buat email dummy dan password default untuk user siswa.
    public function store(Request $request)
    {
        if (!$request->has('email')) {
            $emailName = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->nama_lengkap ?? 'siswa'));
            $request->merge([
                'email' => $emailName . rand(100, 999) . '@fella.id',
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);
        }

        $validated = $request->validate([
            'tipe_pendaftar' => 'required|in:self,wali',
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'required|string|max:50',
            'nama_wali' => 'required_if:tipe_pendaftar,wali|nullable|string|max:255',
            'hubungan_wali' => 'required_if:tipe_pendaftar,wali|nullable|string|max:100',
            'no_hp_wali' => 'required_if:tipe_pendaftar,wali|nullable|string|max:50',
            'alamat' => 'required|string',
            'instagram' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'program' => 'nullable|string|max:255',
            'jenis_program' => 'nullable|string|max:255',
            'lokasi_les' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['kode_pendaftaran'] = $this->generateKodePendaftaran();
        $validated['status'] = 'pending';
        $validated['tanggal_daftar'] = now();

        if ($validated['tipe_pendaftar'] === 'self') {
            $validated['nama_wali'] = $validated['nama_lengkap'];
            $validated['hubungan_wali'] = 'Diri Sendiri';
            $validated['no_hp_wali'] = $validated['no_whatsapp'];
        }

        try {
            $pendaftaran = Pendaftaran::create($validated);

            $programValue = in_array($validated['program'] ?? '', Program::values(), true)
                ? $validated['program']
                : Program::SWIM_STARS->value;
            $jenisProgramValue = in_array($validated['jenis_program'] ?? '', JenisProgram::values(), true)
                ? $validated['jenis_program']
                : JenisProgram::GROUP->value;
            $lokasiValue = in_array($validated['lokasi_les'] ?? '', LokasiLes::values(), true)
                ? $validated['lokasi_les']
                : LokasiLes::ISTANA_MENTARI->value;

            $siswa = Siswa::create([
                'nama' => $validated['nama_lengkap'],
                'umur' => null,
                'no_hp_ortu' => $validated['no_whatsapp'],
                'program' => $programValue,
                'jenis_program' => $jenisProgramValue,
                'lokasi_les' => $lokasiValue,
                'total_sesi' => 4,
                'sesi_terpakai' => 0,
                'status' => 'tidak_aktif',
            ]);

            $user = User::create([
                'name' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'siswa',
                'siswa_id' => $siswa->id,
            ]);

            $pendaftaran->update([
                'siswa_id' => $siswa->id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan pendaftaran. Terjadi kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json(array_merge($pendaftaran->toArray(), [
            'user' => [
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]), 201);
    }

    public function show(Pendaftaran $pendaftaran)
    {
        return response()->json($pendaftaran, 200);
    }

    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:100',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'tempat_lahir' => 'sometimes|required|string|max:255',
            'tanggal_lahir' => 'sometimes|required|date',
            'no_whatsapp' => 'sometimes|required|string|max:50',
            'nama_wali' => 'sometimes|required|string|max:255',
            'hubungan_wali' => 'sometimes|required|string|max:100',
            'alamat' => 'sometimes|required|string',
            'instagram' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'program' => 'nullable|string|max:255',
            'jenis_program' => 'nullable|string|max:255',
            'lokasi_les' => 'nullable|string|max:255',
            'status' => 'sometimes|required|in:pending,diterima,ditolak',
            'verified_by' => 'nullable|string|max:255',
            'verified_at' => 'nullable|date',
            'siswa_id' => 'nullable|string',
        ]);

        // Prevent changing status if already accepted/rejected
        if (isset($validated['status']) && $pendaftaran->status !== 'pending') {
            return response()->json([
                'message' => 'Pendaftaran sudah pernah diverifikasi sebelumnya. Tidak dapat mengubah status.',
                'current_status' => $pendaftaran->status,
                'siswa_id' => $pendaftaran->siswa_id
            ], 400);
        }



        if (isset($validated['status']) && $validated['status'] !== 'pending' && empty($validated['verified_at'])) {
            $validated['verified_at'] = now();
        }

        $pendaftaran->update($validated);

        // Aktifkan akun siswa jika status pendaftaran diubah menjadi diterima
        if (isset($validated['status']) && $validated['status'] === 'diterima') {
            if ($pendaftaran->siswa) {
                $pendaftaran->siswa->update(['status' => 'aktif']);
            }
        }

        return response()->json($pendaftaran, 200);
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();
        return response()->json(['message' => 'Pendaftaran deleted'], 200);
    }

    private function generateKodePendaftaran(): string
    {
        $date = now()->format('Ymd');
        $attempt = 1;
        try {
            // Start with today's count + 1 as a hint, but ensure uniqueness by checking existence
            $attempt = Pendaftaran::whereDate('created_at', now()->toDateString())->count() + 1;
        } catch (\Exception $e) {
            $attempt = 1;
        }

        // Loop until we find a kode_pendaftaran that doesn't exist yet (avoid unique constraint failures)
        $maxTries = 1000;
        for ($i = 0; $i < $maxTries; $i++) {
            $seq = $attempt + $i;
            $code = sprintf('REG-%s-%03d', $date, $seq);
            try {
                $exists = Pendaftaran::where('kode_pendaftaran', $code)->exists();
            } catch (\Exception $e) {
                // If the DB check fails, break and return current code
                Log::warning('generateKodePendaftaran db check failed', ['error' => $e->getMessage()]);
                return $code;
            }

            if (!$exists) {
                return $code;
            }
        }

        // As a last resort, append a random suffix to avoid collisions
        return sprintf('REG-%s-%03d-%s', $date, $attempt, substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4));
    }
}
