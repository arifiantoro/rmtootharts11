@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-3">💳 Daftar Pembayaran Pasien: {{ $rekamMedis->pasien->nama }}</h2>
    <p><strong>No. Rekam Medis:</strong> {{ $rekamMedis->id }}</p>

    <div class="mb-3">
        <a href="{{ route('pembayaran.create', $rekamMedis->id) }}" class="btn btn-primary">➕ Tambah Pembayaran</a>
        <a href="{{ route('perawatan.index', $rekamMedis->pasien_id) }}" class="btn btn-secondary">⬅️ Kembali</a>
    </div>

    @if($pembayarans->isEmpty())
        <div class="alert alert-info">Belum ada data pembayaran.</div>
    @else
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal Pembayaran</th>
                    <th>Metode</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pembayarans as $p)
                    <tr>
                        <td>{{ $p->tanggal_pembayaran }}</td>
                        <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                        <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('pembayaran.show', $p->id) }}" class="btn btn-sm btn-success">🔍 Lihat</a>
                            <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pembayaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
