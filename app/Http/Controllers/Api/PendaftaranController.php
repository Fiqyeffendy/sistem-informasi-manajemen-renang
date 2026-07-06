<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        return response()->json(Pendaftaran::orderBy('created_at', 'desc')->get(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nama_panggilan' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'required|string|max:50',
            'nama_wali' => 'required|string|max:255',
            'hubungan_wali' => 'required|string|max:100',
            'alamat' => 'required|string',
            'instagram' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'program' => 'nullable|string|max:255',
            'jenis_program' => 'nullable|string|max:255',
            'lokasi_les' => 'nullable|string|max:255',
        ]);

        $validated['kode_pendaftaran'] = $this->generateKodePendaftaran();
        $validated['status'] = 'pending';
        $validated['tanggal_daftar'] = now();

        try {
            $pendaftaran = Pendaftaran::create($validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan pendaftaran. Terjadi kesalahan server.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json($pendaftaran, 201);
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
            'siswa_id' => 'nullable|integer',
        ]);

        // Prevent changing status if already accepted/rejected
        if (isset($validated['status']) && $pendaftaran->status !== 'pending') {
            return response()->json([
                'message' => 'Pendaftaran sudah pernah diverifikasi sebelumnya. Tidak dapat mengubah status.',
                'current_status' => $pendaftaran->status,
                'siswa_id' => $pendaftaran->siswa_id
            ], 400);
        }

        // Prevent double acceptance if siswa_id already exists
        if (isset($validated['status']) && $validated['status'] !== 'pending' && !empty($pendaftaran->siswa_id)) {
            return response()->json([
                'message' => 'Pendaftaran ini sudah dibuat ke data siswa sebelumnya. Tidak dapat diverifikasi lagi.',
                'siswa_id' => $pendaftaran->siswa_id
            ], 400);
        }

        if (isset($validated['status']) && $validated['status'] !== 'pending' && empty($validated['verified_at'])) {
            $validated['verified_at'] = now();
        }

        $pendaftaran->update($validated);

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
