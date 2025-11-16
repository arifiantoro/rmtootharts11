{{-- resources/views/rekammedis/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Rekam Medis Pasien</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="rekamTable" class="table table-striped table-hover align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Kelamin</th>
                        <th>No. Register</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pasiens as $index => $pasien)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $pasien->nama }}</td>
                            <td>
                                @if($pasien->jenis_kelamin == 'Laki-laki')
                                    <span class="badge bg-primary">Laki-laki</span>
                                @else
                                    <span class="badge bg-info text-white">Perempuan</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $pasien->noreg }}</span></td>
                            <td>
                                @if($pasien->rekamMedis->isNotEmpty())
                                    {{-- Jika pasien sudah punya rekam medis --}}
                                    <a href="{{ route('perawatan.index', $pasien->rekamMedisTerakhir->id) }}" 
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-clipboard2-pulse"></i> Perawatan
                                    </a>

                                    <a href="{{ route('rekammedis.show', $pasien->rekamMedisTerakhir->id) }}" 
                                        class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>

                                    {{-- <a href="{{ route('rekammedis.edit', $pasien->rekamMedisTerakhir->id) }}" 
                                        class="btn btn-sm btn-warning text-dark">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a> --}}
                                @else
                                    {{-- Jika pasien belum punya rekam medis --}}
                                    <a href="{{ route('rekammedis.create', $pasien->id) }}" 
                                        class="btn btn-sm btn-success">
                                        <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#rekamTable').DataTable({
        pageLength: 10,
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
