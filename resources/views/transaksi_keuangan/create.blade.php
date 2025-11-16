@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-4">Tambah Transaksi Keuangan</h3>

  <form action="{{ route('transaksi-keuangan.store') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label>Tanggal</label>
      <input type="date" name="tanggal" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Jenis Transaksi</label>
      <select name="jenis" class="form-select" required>
        <option value="Pendapatan">Pendapatan (Debit)</option>
        <option value="Pengeluaran">Pengeluaran (Kredit)</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Kategori</label>
      <select name="kategori" class="form-select" required>
        <option value="Pendapatan">Pendapatan</option>
        <option value="Gaji">Gaji</option>
        <option value="Listrik">Listrik</option>
        <option value="Internet">Internet</option>
        <option value="PDAM">PDAM</option>
        <option value="Iuran RT RW">Iuran RT RW</option>
        <option value="Operasional">Operasional</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Keterangan</label>
      <input type="text" name="keterangan" class="form-control">
    </div>

    <div class="mb-3">
      <label>Nominal</label>
      <input type="number" step="0.01" name="nominal" class="form-control" required>
    </div>

    <div class="mb-3">
      <label>Metode Pembayaran</label>
      <select name="metode_pembayaran" class="form-select" required>
        <option value="Cash">Cash</option>
        <option value="Transfer">Transfer</option>
        <option value="QRIS">QRIS</option>
        <option value="Lainnya">Lainnya</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="{{ route('transaksi-keuangan.index') }}" class="btn btn-secondary">Kembali</a>
  </form>
</div>
@endsection
