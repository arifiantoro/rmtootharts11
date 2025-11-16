@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">✏️ Edit Stok Barang</h4>

    <form action="{{ route('stok-barang.update', $stokBarang->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kode_barang" class="form-label">Kode Barang</label>
            <input type="text" id="kode_barang" name="kode_barang" class="form-control" 
                   value="{{ old('kode_barang', $stokBarang->kode_barang) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="nama_barang" class="form-label">Nama Barang</label>
            <input type="text" id="nama_barang" name="nama_barang" class="form-control" 
                   value="{{ old('nama_barang', $stokBarang->nama_barang) }}" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select name="kategori" id="kategori" class="form-select" required>
                @foreach (['Obat kumur', 'Anti nyeri', 'Antibiotik', 'Lainnya'] as $kategori)
                    <option value="{{ $kategori }}" 
                        {{ old('kategori', $stokBarang->kategori) == $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Jumlah Stok</label>
            <input type="number" id="stok" name="stok" class="form-control" 
                   value="{{ old('stok', $stokBarang->stok) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="harga_satuan" class="form-label">Harga Satuan</label>
            <input type="number" id="harga_satuan" name="harga_satuan" class="form-control" 
                   value="{{ old('harga_satuan', $stokBarang->harga_satuan) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control" rows="2">{{ old('keterangan', $stokBarang->keterangan) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('stok-barang.index') }}" class="btn btn-secondary">← Kembali</a>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
