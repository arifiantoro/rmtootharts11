@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📦 Daftar Stok Barang</h3>
    <a href="{{ route('stok-barang.create') }}" class="btn btn-primary mb-3">➕ Tambah Barang</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $b)
                <tr>
                    <td>{{ $b->nama_barang }}</td>
                    <td>{{ $b->kategori }}</td>
                    <td>{{ $b->stok }}</td>
                    <td>Rp {{ number_format($b->harga_satuan, 0, ',', '.') }}</td>
                    <td>{{ $b->keterangan ?? '-' }}</td>
                    <td>
                        <a href="{{ route('stok-barang.edit', $b->id) }}" class="btn btn-sm btn-warning">✏️</a>
                        <form action="{{ route('stok-barang.destroy', $b->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
