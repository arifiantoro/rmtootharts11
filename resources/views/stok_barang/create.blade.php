@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ Tambah Stok Barang</h3>

    <form action="{{ route('stok-barang.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>
            <select name="kategori" class="form-select" required>
                @foreach($kategoriList as $kategori)
                    <option value="{{ $kategori }}">{{ $kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" min="0" required>
        </div>

        <div class="mb-3">
            <label>Harga Satuan (Rp)</label>
            <input type="number" step="0.01" name="harga_satuan" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="{{ route('stok-barang.index') }}" class="btn btn-secondary">↩️ Kembali</a>
    </form>
</div>
@endsection
