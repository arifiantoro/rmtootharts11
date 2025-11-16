<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RekamMedis;
use App\Models\Odontogram;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

class RekamMedisController extends Controller
{
    public function index()
    {
        // ✅ Ambil data pasien beserta relasi rekam medis
        $pasiens = Pasien::with('rekamMedis')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rekammedis.index', compact('pasiens'));
    }

    public function create($pasien_id)
    {
        $pasien = Pasien::findOrFail($pasien_id);

        // ✅ Dummy data dokter sementara
        $dokters = [
            ['id' => 1, 'nama' => 'drg. Andi'],
            ['id' => 2, 'nama' => 'drg. Budi'],
        ];

        return view('rekammedis.create', compact('pasien', 'dokters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'dokter_id' => 'required|integer', // ⚠️ ubah sementara tanpa exists:dokters,id
            'tanggal_perawatan' => 'required|date',
            'alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
            'catatan_khusus' => 'nullable|string',
            'rencana_perawatan' => 'nullable|string',
            'jadwal_perawatan_selanjutnya' => 'nullable|date',
            'odontogram' => 'nullable|array',
        ]);

        // ✅ Checkbox kondisi
        $validated['hamil'] = in_array('Hamil', $request->input('kondisi', []));
        $validated['mag'] = in_array('Mag', $request->input('kondisi', []));

        // ✅ Simpan data rekam medis
        $rekamMedis = RekamMedis::create($validated);

        // ✅ Simpan data odontogram bila ada
        if ($request->has('odontogram') && is_array($request->odontogram)) {
            foreach ($request->odontogram as $toothData) {
                if (!empty($toothData['nomor_gigi']) && !empty($toothData['status'])) {
                    $rekamMedis->odontogram()->create([
                        'nomor_gigi' => $toothData['nomor_gigi'],
                        'status' => $toothData['status'],
                        'tipe' => $toothData['tipe'] ?? 'dewasa',
                    ]);
                }
            }
        }

        return redirect()
            ->route('rekammedis.index')
            ->with('success', 'Rekam medis dan odontogram berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);

        // ✅ Dummy data dokter sementara
        $dokters = [
            ['id' => 1, 'nama' => 'drg. Andi'],
            ['id' => 2, 'nama' => 'drg. Rina'],
            ['id' => 3, 'nama' => 'drg. Budi'],
        ];

        return view('rekammedis.edit', compact('rekamMedis', 'dokters'));
    }

    public function update(Request $request, $id)
{
    $validated = $request->validate([
        'dokter_id' => 'required|integer',
        'tanggal_perawatan' => 'required|date',
        'alergi' => 'nullable|string',
        'riwayat_penyakit' => 'nullable|string',
        'catatan_khusus' => 'nullable|string',
        'rencana_perawatan' => 'nullable|string',
        'jadwal_perawatan_selanjutnya' => 'nullable|date',
        'kondisi' => 'nullable|array',
        'odontogram' => 'nullable',
    ]);

    // kondisi
    $validated['hamil'] = in_array('Hamil', $request->input('kondisi', []));
    $validated['mag'] = in_array('Mag', $request->input('kondisi', []));

    $rekamMedis = RekamMedis::findOrFail($id);

    DB::beginTransaction();

    try {
        // 🔹 Update data utama
        $rekamMedis->update($validated);

        // 🔹 Ambil & decode data odontogram
        $odontogramData = $request->input('odontogram', []);

        if (!is_array($odontogramData)) {
            $odontogramData = json_decode($odontogramData, true) ?? [];
        }

        // 🔹 Update odontogram hanya jika ada data
        if (!empty($odontogramData)) {
            $rekamMedis->odontogram()->delete();

            foreach ($odontogramData as $tooth) {
                // Hanya simpan kalau status valid
                if (
                    !empty($tooth['nomor_gigi']) &&
                    !empty($tooth['status']) &&
                    in_array($tooth['status'], ['karies', 'hilang', 'belum-erupsi', 'karang-gigi', 'sisa-akar'])
                ) {
                    $rekamMedis->odontogram()->create([
                        'nomor_gigi' => $tooth['nomor_gigi'],
                        'status' => $tooth['status'],
                        'tipe' => $tooth['tipe'] ?? null,
                    ]);
                }
            }
        }

        DB::commit();

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error('Gagal update rekam medis', ['error' => $e->getMessage()]);
        return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
    }

    return redirect()
        ->route('rekammedis.show', $rekamMedis->id)
        ->with('success', 'Rekam medis berhasil diperbarui.');
}

    public function show($id)
    {
        $rekamMedis = RekamMedis::with(['pasien', 'dokter', 'odontogram'])->findOrFail($id);

        return view('rekammedis.show', compact('rekamMedis'));
    }
}
