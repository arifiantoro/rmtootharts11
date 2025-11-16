<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Odontogram;

class OdontogramController extends Controller
{
    /**
     * Simpan data odontogram dari form rekam medis
     */
    public function store(Request $request)
    {
        $request->validate([
            'rekam_medis_id' => 'required|exists:rekam_medis,id',
            'odontogram' => 'required|array',
            'odontogram.*.nomor_gigi' => 'required|string',
            'odontogram.*.status' => 'nullable|string',
            'odontogram.*.tipe' => 'nullable|in:dewasa,anak',
        ]);

        foreach ($request->odontogram as $tooth) {
            Odontogram::updateOrCreate(
                [
                    'rekam_medis_id' => $request->rekam_medis_id,
                    'nomor_gigi' => $tooth['nomor_gigi'],
                ],
                [
                    'status' => $tooth['status'] ?? null,
                    'tipe' => $tooth['tipe'] ?? 'dewasa',
                    'keterangan' => $tooth['keterangan'] ?? null,
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Data odontogram berhasil disimpan.']);
    }

    /**
     * Hapus status odontogram tertentu
     */
    public function destroy($id)
    {
        $odontogram = Odontogram::findOrFail($id);
        $odontogram->delete();

        return response()->json(['success' => true, 'message' => 'Data odontogram dihapus.']);
    }

    /**
     * Ambil data odontogram berdasarkan rekam medis
     */
    public function getByRekamMedis($rekamMedisId)
    {
        $odontograms = Odontogram::where('rekam_medis_id', $rekamMedisId)->get();

        return response()->json($odontograms);
    }
}
