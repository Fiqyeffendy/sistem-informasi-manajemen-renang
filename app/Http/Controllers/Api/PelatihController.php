<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelatih;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelatihController extends Controller
{
    // GET /api/pelatih - Ambil semua pelatih
    public function index()
    {
        return response()->json(Pelatih::orderBy('nama', 'asc')->get(), 200);
    }

    // POST /api/pelatih - Tambah pelatih baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'              => 'required|string|max:255',
            'no_hp'             => 'nullable|string|max:50',
            'email'             => 'nullable|email|unique:pelatih,email|max:255',
            'spesialisasi'      => 'nullable|array',
            'spesialisasi.*'    => 'string|in:Toddler,Kids,Adults,Spesial',
            'jadwal_mengajar'   => 'nullable|array',
            'jadwal_mengajar.*.hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jadwal_mengajar.*.jam'  => 'required|date_format:H:i',
            'status'            => 'required|in:aktif,cuti',
            'alasan_cuti'       => 'required_if:status,cuti|nullable|string',
        ]);

        $pelatih = Pelatih::create($validated);
        return response()->json($pelatih, 201);
    }

    // GET /api/pelatih/{id} - Ambil 1 pelatih
    public function show(Pelatih $pelatih)
    {
        return response()->json($pelatih, 200);
    }

    // PUT /api/pelatih/{id} - Update data pelatih
    public function update(Request $request, Pelatih $pelatih)
    {
        $validated = $request->validate([
            'nama'              => 'sometimes|required|string|max:255',
            'no_hp'             => 'nullable|string|max:50',
            'email'             => [
                'nullable',
                'email',
                Rule::unique('pelatih', 'email')->ignore($pelatih->id),
                'max:255'
            ],
            'spesialisasi'      => 'nullable|array',
            'spesialisasi.*'    => 'string|in:Toddler,Kids,Adults,Spesial',
            'jadwal_mengajar'   => 'nullable|array',
            'jadwal_mengajar.*.hari' => 'required|string|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jadwal_mengajar.*.jam'  => 'required|date_format:H:i',
            'status'            => 'sometimes|required|in:aktif,cuti',
            'alasan_cuti'       => 'required_if:status,cuti|nullable|string',
        ]);

        // Reset alasan_cuti jika status diubah kembali ke aktif
        if (isset($validated['status']) && $validated['status'] === 'aktif') {
            $validated['alasan_cuti'] = null;
        }

        $pelatih->update($validated);
        return response()->json($pelatih, 200);
    }

    // DELETE /api/pelatih/{id} - Hapus pelatih
    public function destroy(Pelatih $pelatih)
    {
        $pelatih->delete();
        return response()->json(['message' => 'Pelatih deleted successfully'], 200);
    }
}
