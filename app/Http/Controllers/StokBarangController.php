<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;

class StokBarangController extends Controller
{
    public function index()
    {
        $barangs = StokBarang::orderBy('nama_barang')->get();
        return view('stok_barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoriList = ['Obat kumur', 'Anti nyeri', 'Antibiotik', 'Lainnya'];
        return view('stok_barang.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Obat kumur,Anti nyeri,Antibiotik,Lainnya',
            'stok' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        StokBarang::create($validated);

        return redirect()->route('stok-barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(StokBarang $stokBarang)
    {
        $kategoriList = ['Obat kumur', 'Anti nyeri', 'Antibiotik', 'Lainnya'];
        return view('stok_barang.edit', compact('stokBarang', 'kategoriList'));
    }

    public function update(Request $request, StokBarang $stokBarang)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Obat kumur,Anti nyeri,Antibiotik,Lainnya',
            'stok' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $stokBarang->update($validated);

        return redirect()->route('stok-barang.index')->with('success', 'Data barang berhasil diperbarui.');
    }

    public function destroy(StokBarang $stokBarang)
    {
        $stokBarang->delete();
        return redirect()->route('stok-barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
