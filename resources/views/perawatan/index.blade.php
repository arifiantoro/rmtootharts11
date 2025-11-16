@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Header Data Pasien --}}
    <div class="card shadow-sm mb-4 border-0">
        <div class="card-header bg-primary text-white fw-bold fs-5">
            Rekam Medis Pasien
        </div>
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <h4 class="fw-bold mb-2">No Rekam Medis : {{ $rekamMedis->id ?? '—' }}</h4>
                <p><strong>Tanggal Daftar :</strong> {{ $pasien->created_at->format('d-m-Y') }}</p>
                <p><strong>Nama :</strong> {{ $pasien->nama }}</p>
                <p><strong>No HP :</strong> {{ $pasien->nomor_hp }}</p>
                <p><strong>Jenis Kelamin :</strong> {{ ucfirst($pasien->jenis_kelamin) }}</p>
            </div>
            <div class="text-end">
                <a href="https://wa.me/{{ $pasien->nomor_hp }}" target="_blank" class="btn btn-success mb-2">
                    💬 Chat via WhatsApp
                </a><br>

                {{-- tombol tambah perawatan (muncul kalau ada rekamMedis) --}}
                @if(isset($rekamMedis))
                    <a href="{{ route('perawatan.create', $rekamMedis->id) }}" class="btn btn-danger">
                        ➕ Perawatan Baru
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- daftar perawatan / pesan --}}
@if(!empty($message))
    <div class="alert alert-info text-center">{{ $message }}</div>
@else
    <table class="table table-hover align-middle">
    <thead class="table-light">
            <tr>
                <th>Tanggal Periksa</th>
                <th>Dokter</th>
                <th>Perawatan</th>
                <th>Jadwal Kontrol</th>
                <th>Aksi</th>
                <th>Pembayaran</th> 
            </tr>
        </thead>
        <tbody>
            @forelse($perawatans as $p)
                <tr>
                    <td>{{ optional($p->tanggal_perawatan) ? \Carbon\Carbon::parse($p->tanggal_perawatan)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $p->dokter->nama ?? '-' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($p->catatan_perawatan ?? $p->rencana_perawatan ?? '-', 60) }}</td>
                    <td>{{ $p->jadwal_perawatan_selanjutnya ? \Carbon\Carbon::parse($p->jadwal_perawatan_selanjutnya)->format('d-m-Y') : '-' }}</td>
                    
                    {{-- 🔧 Aksi utama --}}
                    <td>
                        <a href="{{ route('perawatan.edit', $p->id) }}" class="btn btn-sm btn-primary">✏️ Edit</a>
                    </td>

                    {{-- 💳 Kolom baru untuk Pembayaran --}}
                    <td>
                       @if($p->pembayaran)
                        <a href="{{ route('pembayaran.show', $p->pembayaran->id) }}" class="btn btn-success btn-sm">
                            💳 Detail
                        </a>
                    @else
                        <a href="{{ route('pembayaran.create', ['perawatanId' => $p->id]) }}" class="btn btn-warning btn-sm">
                            ➕ Buat
                        </a>
                    @endif
                </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada data perawatan untuk pasien ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endif
@endsection