@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Pembayaran Baru</h2>
    <p>Pasien: <strong>{{ $rekamMedis->pasien->nama }}</strong></p>

    <form action="{{ route('pembayaran.store', ['perawatanId' => $perawatan->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="perawatan_id" value="{{ $perawatan->id }}">
        <div class="mb-3">
            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
            <input type="date" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                <option value="">-- Pilih Metode --</option>
                <option value="tunai">Tunai</option>
                <option value="transfer">Transfer</option>
                <option value="kartu">Kartu Debit/Kredit</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="total_bayar" class="form-label">Total Bayar (Rp)</label>
            <input type="number" name="total_bayar" id="total_bayar" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan</button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
