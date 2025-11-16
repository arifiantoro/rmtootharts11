@extends('layouts.app')

@section('content')
<div class="container">
  <h3 class="mb-4">Edit Transaksi Keuangan</h3>

  <form action="{{ route('transaksi-keuangan.update', $transaksi->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label>Tanggal</label>
      <input type="date" name="tanggal" class="form-control" 
             value="{{ old('tanggal', $transaksi->tanggal) }}" required>
    </div>

    <div class="mb-3">
      <label>Jenis Transaksi</label>
      <select name="jenis" class="form-select" required>
        <option value="Pendapatan" 
          {{ $transaksi->debit > 0 ? 'selected' : '' }}>Pendapatan (Debit)</option>
        <option value="Pengeluaran" 
          {{ $transaksi->kredit > 0 ? 'selected' : '' }}>Pengeluaran (Kredit)</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Kategori</label>
      <select name="kategori" class="form-select" required>
        @php
          $kategoris = ['Pendapatan','Gaji','Listrik','Internet','PDAM','Iuran RT RW','Operasional'];
        @endphp
        @foreach ($kategoris as $kategori)
          <option value="{{ $kategori }}" 
            {{ $transaksi->kategori === $kategori ? 'selected' : '' }}>
            {{ $kategori }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-3">
      <label>Keterangan</label>
      <input type="text" name="keterangan" class="form-control"
             value="{{ old('keterangan', $transaksi->keterangan) }}">
    </div>

    <div class="mb-3">
      <label>Nominal</label>
      <input type="number" step="0.01" name="nominal" class="form-control"
             value="{{ old('nominal', $transaksi->debit > 0 ? $transaksi->debit : $transaksi->kredit) }}" required>
    </div>

    <div class="mb-3">
      <label>Metode Pembayaran</label>
      <select name="metode_pembayaran" class="form-select" required>
        @foreach (['Cash','Transfer','QRIS','Lainnya'] as $metode)
          <option value="{{ $metode }}" 
            {{ $transaksi->metode_pembayaran === $metode ? 'selected' : '' }}>
            {{ $metode }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('transaksi-keuangan.index') }}" class="btn btn-secondary">Batal</a>
  </form>
</div>
@endsection
