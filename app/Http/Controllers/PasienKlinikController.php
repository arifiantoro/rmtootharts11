<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienKlinikController extends Controller
{
        public function index()
    {
        // Ambil semua pasien dengan total perawatan (jika relasi perawatans tetap diperlukan)
        $pasiens = \App\Models\Pasien::withCount('perawatans')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($pasiens as $pasien) {
            $perawatanCount = $pasien->perawatans_count;
            $jenis = $pasien->jenis_pasien;

            // Tentukan status pasien
            if ($perawatanCount > 1 || (is_string($jenis) && strtolower($jenis) === 'ortho')) {
                $pasien->status_pasien = 'RO';
                $pasien->status_alasan = $perawatanCount > 1
                    ? "Kunjungan: {$perawatanCount}"
                    : "Jenis: Ortho";
            } else {
                $pasien->status_pasien = 'N';
                $pasien->status_alasan = $perawatanCount > 0
                    ? "Kunjungan: {$perawatanCount}"
                    : "Belum ada kunjungan";
            }
        }

        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    /**
     * Simpan data pasien baru
     */
    public function store(Request $request)
    {
    $request->validate([
        'noreg'         => 'required|unique:pasiens,noreg',
        'nama'          => 'required|string|max:255',
        'jenis_pasien' => 'required|string',
        'tempat_lahir'  => 'required|string|max:100',
        'tanggal_lahir' => 'required|date',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'nomor_hp'      => 'required|string|max:20',
    ]);

    // Simpan data
    Pasien::create([
        'noreg'         => $request->noreg,
        'nama'          => $request->nama,
        'jenis_pasien'  => $request->jenis_pasien,
        'tempat_lahir'  => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'nomor_hp'      => $request->nomor_hp,
    ]);

    return redirect()->route('pasien.index')->with('success', 'Pasien berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::findOrFail($id);

        $request->validate([
            'noreg'         => 'required|unique:pasiens,noreg,' . $pasien->id,
            'nama'          => 'required|string|max:255',
            'jenis_pasien'  => 'required|string',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'nomor_hp'      => 'required|string|max:20',
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Pasien berhasil dihapus!');
    }

}
