<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\PembayaranDetail;
use App\Models\Barang;
use Illuminate\Http\Request;

class PembayaranDetailController extends Controller
{
    // Tambahkan item (barang/jasa) ke pembayaran
    public function store(Request $request, $pembayaranId)
    {
        // 🔹 Ambil data pembayaran terlebih dahulu
        $pembayaran = \App\Models\Pembayaran::findOrFail($pembayaranId);

        // validasi
        $validated = $request->validate([
            'barang_id' => 'nullable|exists:stok_barangs,id', // relasi ke tabel stok
            'perawatan_id' => 'nullable|exists:perawatans,id',
            'deskripsi' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
            'diskon' => 'nullable|numeric|min:0', // nilai diskon rupiah
        ]);

        // 🔹 Cek stok sebelum membuat detail
        if (!empty($validated['barang_id'])) {
            $barang = \App\Models\StokBarang::find($validated['barang_id']);

            if (!$barang) {
                return back()->with('error', 'Barang tidak ditemukan.');
            }

            if ($barang->stok < $validated['jumlah']) {
                return back()->with('error', "Stok {$barang->nama_barang} tidak mencukupi. (Tersedia: {$barang->stok})");
            }
        }

        $validated['pembayaran_id'] = $pembayaranId;
        $validated['perawatan_id'] = $pembayaran->perawatan_id;

        // Hitung subtotal setelah diskon
        $hargaTotal = $validated['jumlah'] * $validated['harga_satuan'];
        $validated['subtotal'] = $hargaTotal - ($validated['diskon'] ?? 0);

        // Simpan detail pembayaran
        $detail = \App\Models\PembayaranDetail::create($validated);

        // 🔹 Kurangi stok setelah detail berhasil disimpan
        if (!empty($validated['barang_id'])) {
            $barang->decrement('stok', $validated['jumlah']);
        }

        // 🔹 Hitung ulang total bayar berdasarkan semua detail (setelah diskon)
        $total = \App\Models\PembayaranDetail::where('pembayaran_id', $pembayaranId)
            ->sum('subtotal');

        // 🔹 Update total ke tabel pembayaran
        \App\Models\Pembayaran::where('id', $pembayaranId)
            ->update(['total_bayar' => $total]);

        return redirect()
            ->route('pembayaran.show', $pembayaranId)
            ->with('success', 'Item pembayaran berhasil ditambahkan, stok diperbarui.');
        }

        // Hapus item
        public function destroy($id)
        {
            $detail = \App\Models\PembayaranDetail::findOrFail($id);

            // 🔹 Kembalikan stok barang jika ada barang_id
            if (!empty($detail->barang_id)) {
                $barang = \App\Models\StokBarang::find($detail->barang_id);
                if ($barang) {
                    $barang->increment('stok', $detail->jumlah);
                }
            }

            $pembayaranId = $detail->pembayaran_id;

            // 🔹 Hapus detail
            $detail->delete();

            // 🔹 Hitung ulang total bayar
            $total = \App\Models\PembayaranDetail::where('pembayaran_id', $pembayaranId)
                ->sum('subtotal');

            // 🔹 Update total ke tabel pembayaran
            \App\Models\Pembayaran::where('id', $pembayaranId)
                ->update(['total_bayar' => $total]);

            return redirect()
                ->route('pembayaran.show', $pembayaranId)
                ->with('success', 'Item pembayaran dihapus dan stok barang dikembalikan.');
    }

}
