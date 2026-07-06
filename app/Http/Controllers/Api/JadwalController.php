<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // GET /api/jadwal
    public function index()
    {
        return response()->json(Jadwal::with(['siswa', 'pelatih'])->get(), 200);
    }

    // POST /api/jadwal
    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id'   => 'required|exists:siswa,id',
            'pelatih_id' => 'required|exists:pelatih,id',
            'hari'       => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam'        => 'required|date_format:H:i',
            'lokasi'     => 'required|string',
            'status'     => 'sometimes|required|in:aktif,tidak_aktif,libur',
            'durasi'     => 'sometimes|required|string',
            'tipe'       => 'sometimes|required|in:reguler,backup',
        ]);

        $jadwal = Jadwal::create($validated);
        return response()->json($jadwal->load(['siswa', 'pelatih']), 201);
    }

    // GET /api/jadwal/{jadwal}
    public function show(Jadwal $jadwal)
    {
        return response()->json($jadwal->load(['siswa', 'pelatih']), 200);
    }

    // PUT /api/jadwal/{jadwal}
    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'siswa_id'   => 'sometimes|required|exists:siswa,id',
            'pelatih_id' => 'sometimes|required|exists:pelatih,id',
            'hari'       => 'sometimes|required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam'        => 'sometimes|required|date_format:H:i',
            'lokasi'     => 'sometimes|required|string',
            'status'     => 'sometimes|required|in:aktif,tidak_aktif,libur',
            'durasi'     => 'sometimes|required|string',
            'tipe'       => 'sometimes|required|in:reguler,backup',
        ]);

        $jadwal->update($validated);
        return response()->json($jadwal->load(['siswa', 'pelatih']), 200);
    }

    // DELETE /api/jadwal/{jadwal}
    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return response()->json(['message' => 'Jadwal deleted successfully'], 200);
    }
}
