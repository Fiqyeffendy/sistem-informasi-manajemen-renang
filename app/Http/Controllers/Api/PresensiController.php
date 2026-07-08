<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    // GET /api/presensi
    // Ambil semua presensi dengan relasi siswa, pelatih, dan jadwal.
    public function index()
    {
        $presensis = Presensi::with(['siswa', 'pelatih', 'jadwal'])->orderByDesc('tanggal')->orderByDesc('created_at')->get();
        return response()->json($presensis);
    }

    // POST /api/presensi
    // Simpan presensi baru dengan validasi dan pengecekan duplikat.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'siswa_id' => 'required|exists:siswa,id',
            'pelatih_id' => 'required|exists:pelatih,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:hadir,izin,alpha',
            'catatan' => 'nullable|string',
        ]);

        $exists = Presensi::where('jadwal_id', $validated['jadwal_id'])
            ->where('siswa_id', $validated['siswa_id'])
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Presensi untuk siswa ini pada jadwal tersebut hari ini sudah dicatat.'
            ], 422);
        }

        $presensi = Presensi::create($validated);
        return response()->json($presensi, 201);
    }

    // GET /api/presensi/{id}
    // Ambil detail presensi tertentu.
    public function show(Presensi $presensi)
    {
        $presensi->load(['siswa', 'pelatih', 'jadwal']);
        return response()->json($presensi);
    }

    // PUT /api/presensi/{id}
    // Update data presensi.
    public function update(Request $request, Presensi $presensi)
    {
        $validated = $request->validate([
            'jadwal_id' => 'sometimes|required|exists:jadwal,id',
            'siswa_id' => 'sometimes|required|exists:siswa,id',
            'pelatih_id' => 'sometimes|required|exists:pelatih,id',
            'tanggal' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:hadir,izin,alpha',
            'catatan' => 'nullable|string',
        ]);

        $presensi->update($validated);
        return response()->json($presensi);
    }

    // DELETE /api/presensi/{id}
    public function destroy(Presensi $presensi)
    {
        $presensi->delete();
        return response()->json(['message' => 'Presensi berhasil dihapus.']);
    }
}
