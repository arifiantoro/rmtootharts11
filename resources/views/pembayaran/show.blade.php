@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Pembayaran</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Pasien:</strong> {{ $pembayaran->rekamMedis->pasien->nama }}</p>
            <p><strong>Dokter:</strong> {{ $pembayaran->rekamMedis->dokter->nama ?? '-' }}</p>
            <p><strong>Tanggal:</strong> {{ $pembayaran->tanggal_pembayaran }}</p>
            <p><strong>Metode:</strong> {{ ucfirst($pembayaran->metode_pembayaran) }}</p>
            <p><strong>Total:</strong> Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</p>

            <a href="{{ route('pembayaran.print', $pembayaran->id) }}" target="_blank" class="btn btn-outline-secondary">
                            🖨️ Cetak
            </a>
        </div>
    </div>

    <h4>🧾 Detail Item Pembayaran</h4>
    <form action="{{ route('pembayaran.detail.store', $pembayaran->id) }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3">
                <label>Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Jumlah</label>
                <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
            </div>
            <div class="col-md-2">
                <label>Harga Satuan (Rp)</label>
                <input type="number" name="harga_satuan" class="form-control" value="0" min="0" required>
            </div>
            <div class="col-md-2">
                <label for="barang_id" class="form-label">Barang (opsional)</label>
                <select name="barang_id" id="barang_id" class="form-select">
                    <option value="">- Pilih Barang -</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label>Diskon (Rp)</label>
                <input type="number" name="diskon" class="form-control" value="0" min="0">
            </div>
            <label>Add</label>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">➕</button>
            </div>
        </div>
    </form>

    @if($pembayaran->details->isEmpty())
        <div class="alert alert-info">Belum ada item pembayaran.</div>
    @else
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pembayaran->details as $d)
        <tr>
            <td>{{ $d->deskripsi }}</td>
            <td>{{ $d->jumlah }}</td>
            <td>Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($d->diskon, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
            <td>
                <form action="{{ route('pembayaran.detail.destroy', $d->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    @endif

    <a href="{{ route('perawatan.index', $pembayaran->perawatan->rekam_medis_id) }}" class="btn btn-secondary">⬅️ Kembali</a>
{{-- <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅️ Kembali</a> --}}

</div>
@endsection
