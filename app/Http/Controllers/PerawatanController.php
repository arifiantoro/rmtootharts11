<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perawatan;
use App\Models\RekamMedis;
use App\Models\Pasien;
use App\Models\Dokter;

class PerawatanController extends Controller
{
    // 🔹 Menampilkan semua perawatan untuk satu rekam medis
    public function index($rekamMedisId)
    {
        // ambil rekam medis dan pasien terkait (404 kalau tidak ada)
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($rekamMedisId);
        $pasien = $rekamMedis->pasien;

        // ambil semua perawatan untuk rekam medis tersebut
        $perawatans = Perawatan::with('dokter')
            ->where('rekam_medis_id', $rekamMedisId)
            ->orderBy('tanggal_perawatan', 'desc')
            ->get();

        // pesan bila kosong
        $message = $perawatans->isEmpty() ? 'Belum melakukan perawatan.' : null;

        return view('perawatan.index', compact('pasien', 'rekamMedis', 'perawatans', 'message'));
    }

    // 🔹 Form tambah perawatan baru
    public function create($rekamMedisId)
    {
        $rekamMedis = RekamMedis::with('pasien', 'dokter')->findOrFail($rekamMedisId);
        $pasien = $rekamMedis->pasien;
        $dokter = $rekamMedis->dokter;

        return view('perawatan.create', compact('rekamMedis', 'pasien', 'dokter'));
    }


    // 🔹 Simpan perawatan baru
    public function store(Request $request, $rekamMedisId)
    {
        // Validasi input dari form
        $request->validate([
            'tanggal_perawatan' => 'required|date',
            'catatan_perawatan' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'jadwal_perawatan_selanjutnya' => 'nullable|date',
        ]);

        // Ambil data rekam medis beserta dokter
        $rekamMedis = RekamMedis::with('dokter')->findOrFail($rekamMedisId);

        // Simpan data ke tabel perawatans
        Perawatan::create([
            'rekam_medis_id' => $rekamMedis->id,
            'dokter_id' => $rekamMedis->dokter_id, // otomatis dari rekam medis
            'tanggal_perawatan' => $request->tanggal_perawatan,
            'catatan_perawatan' => $request->catatan_perawatan,
            'catatan_dokter' => $request->catatan_dokter,
            'jadwal_perawatan_selanjutnya' => $request->jadwal_perawatan_selanjutnya,
        ]);

        return redirect()
            ->route('perawatan.index', $rekamMedis->id)
            ->with('success', 'Data perawatan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $perawatan = Perawatan::with('rekamMedis.pasien', 'rekamMedis.dokter')->findOrFail($id);
        $rekamMedis = $perawatan->rekamMedis;
        $pasien = $rekamMedis->pasien;
        $dokter = $rekamMedis->dokter;

        return view('perawatan.edit', compact('perawatan', 'rekamMedis', 'pasien', 'dokter'));
    }

    public function update(Request $request, $id)
    {
        // validasi
        $request->validate([
            'tanggal_perawatan' => 'required|date',
            'catatan_perawatan' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'jadwal_perawatan_selanjutnya' => 'nullable|date',
        ]);

        // ambil perawatan yang sedang diedit
        $perawatan = Perawatan::findOrFail($id);

        // dapatkan rekam_medis terkait dan dokternya
        $rekamMedisId = $perawatan->rekam_medis_id;
        $rekamMedis = RekamMedis::find($rekamMedisId);
        $dokterId = $rekamMedis->dokter_id ?? $perawatan->dokter_id;

        // update (dokter tetap diambil dari rekam medis)
        $perawatan->update([
            'dokter_id' => $dokterId,
            'tanggal_perawatan' => $request->tanggal_perawatan,
            'catatan_perawatan' => $request->catatan_perawatan,
            'catatan_dokter' => $request->catatan_dokter,
            'jadwal_perawatan_selanjutnya' => $request->jadwal_perawatan_selanjutnya,
        ]);

        return redirect()->route('perawatan.index', $rekamMedisId)
                        ->with('success', 'Data perawatan berhasil diperbarui.');
    }

}
