<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\RekamMedis;
use App\Models\Perawatan;
use App\Models\StokBarang;

use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Tampilkan daftar pembayaran untuk satu rekam medis
    public function index($rekamMedisId)
    {
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($rekamMedisId);
        $pembayarans = Pembayaran::where('rekam_medis_id', $rekamMedisId)
            ->with('details')
            ->latest()
            ->get();

        return view('pembayaran.index', compact('rekamMedis', 'pembayarans'));
    }

    // Form tambah pembayaran
public function create($perawatanId)
{
    $perawatan = Perawatan::with('rekamMedis.pasien', 'dokter')->findOrFail($perawatanId);
    $rekamMedis = $perawatan->rekamMedis;
    $pasien = $rekamMedis->pasien;

    return view('pembayaran.create', compact('perawatan', 'rekamMedis', 'pasien'));
}

// Simpan pembayaran baru
public function store(Request $request, $perawatanId)
{
        $perawatan = Perawatan::with('rekamMedis')->findOrFail($perawatanId);
        $rekamMedis = $perawatan->rekamMedis;

        $validated = $request->validate([
            'tanggal_pembayaran' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'total_bayar' => 'required|numeric|min:0',
        ]);

        // Cek apakah perawatan ini sudah dibayar
        $existing = \App\Models\Pembayaran::where('perawatan_id', $perawatan->id)->first();
        if ($existing) {
            return redirect()->route('pembayaran.show', $existing->id)
                ->with('info', 'Pembayaran untuk perawatan ini sudah ada.');
        }

        // Tambahkan hubungan dengan rekam medis dan perawatan
        $validated['rekam_medis_id'] = $rekamMedis->id;
        $validated['perawatan_id'] = $perawatan->id;
        $validated['dokter_id'] = $perawatan->dokter_id;

        //  dd($perawatan->id, $rekamMedis->id, $validated);

        $pembayaran = \App\Models\Pembayaran::create($validated);
        return redirect()->route('pembayaran.show', $pembayaran->id)
            ->with('success', 'Pembayaran berhasil dibuat.');
    }

    // Tampilkan detail pembayaran (dengan item barang/jasa)
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['perawatan', 'details.barang'])->findOrFail($id);
        $barangs = StokBarang::orderBy('nama_barang')->get();

        return view('pembayaran.show', compact('pembayaran', 'barangs'));
    }

    // Hapus pembayaran
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return back()->with('success', 'Pembayaran berhasil dihapus.');
    }

    public function print($id)
    {
        $pembayaran = \App\Models\Pembayaran::with([
        'rekamMedis.pasien',
        'rekamMedis.dokter',
        'details.barang',
        'details.perawatan'
    ])->findOrFail($id);

    // collect catatan_pasien from related perawatans
    $catatan_pasien = $pembayaran->details
    ->pluck('perawatan.catatan_perawatan')
    ->filter()
    ->unique()
    ->implode(', ');
   
        return view('pembayaran.print', compact('pembayaran','catatan_pasien'));
    }

}
