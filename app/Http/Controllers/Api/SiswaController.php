<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // GET /api/siswa - Ambil semua siswa
    public function index()
    {
        return response()->json(Siswa::all(), 200);
    }

    // POST /api/siswa - Buat siswa baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'nullable|integer|min:0',
            'no_hp_ortu' => 'nullable|string|max:50',
            'program' => 'required|in:Fella WaterBabies (Swimming Lessons for Toddlers),Fella SwimStars (Swimming Lessons for Kids),Fella AquaFit (Swimming Lessons for Adults),Fella SwimElite (Swimming Lessons for Elite)',
            'jenis_program' => 'required|in:Small Group,Group,Semi-private,Private',
            'lokasi_les' => 'required|in:Perumahan Istana Mentari,Hotel Aston Sidoarjo,Hotel Swiss Berlinn,Hotel Sofia Juanda,Permata Waterpark Tanggulangin,Regency 21,Premier Place Hotel Juanda,Apartment Prospero Sidoarjo,Legok Asri Park',
            'total_sesi' => 'nullable|integer|min:1',
            'sesi_terpakai' => 'nullable|integer|min:0',
        ]);

        $validated['total_sesi'] = $validated['total_sesi'] ?? 4;
        $validated['sesi_terpakai'] = $validated['sesi_terpakai'] ?? 0;

        $siswa = Siswa::create($validated);
        return response()->json($siswa, 201);
    }

    // GET /api/siswa/:id - Ambil 1 siswa
    public function show(Siswa $siswa)
    {
        return response()->json($siswa, 200);
    }

    // PUT /api/siswa/:id - Update siswa
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string',
            'umur' => 'nullable|integer',
            'no_hp_ortu' => 'nullable|string',
            'program' => 'sometimes|required|in:Fella WaterBabies (Swimming Lessons for Toddlers),Fella SwimStars (Swimming Lessons for Kids),Fella AquaFit (Swimming Lessons for Adults),Fella SwimElite (Swimming Lessons for Elite)',
            'jenis_program' => 'sometimes|required|in:Small Group,Group,Semi-private,Private',
            'lokasi_les' => 'sometimes|required|in:Perumahan Istana Mentari,Hotel Aston Sidoarjo,Hotel Swiss Berlinn,Hotel Sofia Juanda,Permata Waterpark Tanggulangin,Regency 21,Premier Place Hotel Juanda,Apartment Prospero Sidoarjo,Legok Asri Park',
            'total_sesi' => 'nullable|integer|min:1',
            'sesi_terpakai' => 'nullable|integer|min:0',
        ]);

        $siswa->update($validated);
        return response()->json($siswa, 200);
    }

    // DELETE /api/siswa/:id - Hapus siswa
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();
        return response()->json(['message' => 'Siswa deleted'], 200);
    }
}