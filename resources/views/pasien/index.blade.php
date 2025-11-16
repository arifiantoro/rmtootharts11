<!-- resources/views/anggota/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pasien</h1>

    <a href="{{ route('pasien.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-person-plus"></i> Tambah Pasien
    </a>

    <div class="card shadow-sm">
        <div class="card-body">
        <div class="table-responsive">
            <table id="pasien-table" class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenis Pasien</th>
                        <th>Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Nomor Register</th>
                        <th>Status</th> {{-- kolom baru --}}
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pasiens as $pasien)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="fw-bold">{{ $pasien->nama }}</td>
                            <td class="fw-bold">{{ $pasien->jenis_pasien }}</td>
                            <td>{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d M Y') }}</td>
                            <td>
                                @if($pasien->jenis_kelamin == 'Laki-laki')
                                    <span class="badge bg-primary">Laki-laki</span>
                                @else
                                    <span class="badge bg-info text-white">Perempuan</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $pasien->noreg }}</span></td>

                            {{-- Status (N / RO) --}}
                            <td>
                                @if(isset($pasien->status_pasien) && $pasien->status_pasien === 'RO')
                                    <span class="badge bg-success" title="{{ $pasien->status_alasan ?? '' }}">Orth</span>
                                @else
                                    <span class="badge bg-warning text-dark" title="{{ $pasien->status_alasan ?? '' }}">New</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus pasien ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#pasien-table').DataTable({
        pageLength: 10, // tampilkan 10 data per halaman
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Semua"]],
        language: {
            search: "Cari pasien:",
            lengthMenu: "Tampilkan _MENU_ data",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "←",
                next: "→"
            },
            zeroRecords: "Tidak ada data ditemukan"
        }
    });
});
</script>
@endpush

