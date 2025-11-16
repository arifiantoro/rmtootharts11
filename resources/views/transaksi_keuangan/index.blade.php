@extends('layouts.app')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Laporan Transaksi Keuangan</h3>
    <a href="{{ route('transaksi-keuangan.create') }}" class="btn btn-primary">
      + Tambah Transaksi
    </a>
  </div>

  {{-- 🔍 Filter --}}
  <form method="GET" class="mb-3 d-flex gap-2 align-items-center">
    <select name="filter" class="form-select w-auto" onchange="this.form.submit()">
      <option value="bulan_ini" {{ $filter === 'bulan_ini' ? 'selected' : '' }}>Bulan Ini</option>
      <option value="6_bulan" {{ $filter === '6_bulan' ? 'selected' : '' }}>6 Bulan Terakhir</option>
      <option value="tahun_ini" {{ $filter === 'tahun_ini' ? 'selected' : '' }}>Tahun Ini</option>
    </select>
    <span class="text-muted small">
      ({{ $start->format('d M Y') }} — {{ $end->format('d M Y') }})
    </span>
  </form>

  {{-- 🔢 Ringkasan Keuangan --}}
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card border-success">
        <div class="card-body text-success">
          <h6>Total Pendapatan (Debit)</h6>
          <h4>Rp {{ number_format($totalDebit, 0, ',', '.') }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-danger">
        <div class="card-body text-danger">
          <h6>Total Pengeluaran (Kredit)</h6>
          <h4>Rp {{ number_format($totalKredit, 0, ',', '.') }}</h4>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-primary">
        <div class="card-body text-primary">
          <h6>Saldo Akhir</h6>
          <h4>Rp {{ number_format($saldo, 0, ',', '.') }}</h4>
        </div>
      </div>
    </div>
  </div>

  {{-- 📋 Tabel Transaksi --}}
  <div class="card">
    <div class="card-body">
      <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Keterangan</th>
            <th class="text-end">Debit (Pendapatan)</th>
            <th class="text-end">Kredit (Pengeluaran)</th>
            <th>Metode</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($transaksis as $trx)
            <tr>
              <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d M Y') }}</td>
              <td>{{ $trx->kategori }}</td>
              <td>{{ $trx->keterangan }}</td>
              <td class="text-end">
                {{ $trx->debit > 0 ? 'Rp '.number_format($trx->debit, 0, ',', '.') : '-' }}
              </td>
              <td class="text-end">
                {{ $trx->kredit > 0 ? 'Rp '.number_format($trx->kredit, 0, ',', '.') : '-' }}
              </td>
              <td>{{ $trx->metode_pembayaran }}</td>
              <td>
                <a href="{{ route('transaksi-keuangan.edit', $trx->id) }}" class="btn btn-sm btn-warning">
                  <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('transaksi-keuangan.destroy', $trx->id) }}" 
                      method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus transaksi ini?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center text-muted">Tidak ada transaksi dalam periode ini.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
