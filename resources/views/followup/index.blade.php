@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Follow Up Pasien</h3>

    <!-- NAV TABS -->
    <ul class="nav nav-tabs mb-3" id="followupTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="zero-tab" data-bs-toggle="tab" data-bs-target="#zero" type="button">
                0 Perawatan
                <span class="badge bg-secondary">{{ $zeroPerawatan->total() }}</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="aktif-tab" data-bs-toggle="tab" data-bs-target="#aktif" type="button">
                Perawatan Aktif
                <span class="badge bg-warning">{{ $perawatanAktif->total() }}</span>
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button">
                Butuh Follow Up (>6 bulan)
                <span class="badge bg-danger">{{ $selesaiLama->total() }}</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="followupTabsContent">

        {{-- =======================================================
            TAB 1 — PASIEN 0 PERAWATAN
        ======================================================== --}}
        <div class="tab-pane fade show active" id="zero" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Pasien Tanpa Perawatan</h5>

                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nomor HP</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($zeroPerawatan as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>{{ $p->nomor_hp ?? '-' }}</td>
                                    <td>{{ $p->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('rekammedis.create', $p->id) }}" class="btn btn-sm btn-success">
                                            Buat Rekam Medis
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 d-flex justify-content-end">
                        {{ $zeroPerawatan->links('vendor.pagination.bubble') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
            TAB 2 — PERAWATAN AKTIF
        ======================================================== --}}
        <div class="tab-pane fade" id="aktif" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Perawatan Aktif (Tanpa Jadwal Kontrol Selanjutnya)</h5>

                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Pasien</th>
                                <th>No HP</th>
                                <th>Last Perawatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perawatanAktif as $p)
                                @php
                                    $latest = $p->latestPerawatan();
                                    $tanggal = $latest?->tanggal_perawatan
                                        ? \Carbon\Carbon::parse($latest->tanggal_perawatan)->format('d M Y')
                                        : '-';
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $p->rekamMedisTerbaru->jenis_pasien ?? '-' }}</span>
                                    </td>
                                    <td>{{ $p->nomor_hp ?? '-' }}</td>
                                    <td>{{ $tanggal }}</td>
                                    <td>
                                        <a href="{{ route('perawatan.index', $p->id) }}" class="btn btn-sm btn-primary">Lihat Perawatan</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 d-flex justify-content-end">
                        {{ $perawatanAktif->links('vendor.pagination.bubble') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- =======================================================
            TAB 3 — FOLLOW UP > 6 BULAN
        ======================================================== --}}
        <div class="tab-pane fade" id="selesai" role="tabpanel">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Follow Up (> 6 Bulan Tidak Kontrol)</h5>

                    <table class="table table-striped table-hover mt-3">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Pasien</th>
                                <th>No HP</th>
                                <th>Last Perawatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selesaiLama as $p)
                                @php
                                    $latest = $p->latestPerawatan();
                                    $tanggal = $latest?->tanggal_perawatan
                                        ? \Carbon\Carbon::parse($latest->tanggal_perawatan)->format('d M Y')
                                        : '-';
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->nama }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $p->rekamMedisTerbaru->jenis_pasien ?? '-' }}</span>
                                    </td>
                                    <td>{{ $p->nomor_hp ?? '-' }}</td>
                                    <td>{{ $tanggal }}</td>
                                    <td>
                                        <a href="https://wa.me/{{ $p->nomor_hp }}" class="btn btn-sm btn-success" target="_blank">Kirim WA</a>
                                        <a href="{{ route('perawatan.index', $p->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-3 d-flex justify-content-end">
                        {{ $selesaiLama->links('vendor.pagination.bubble') }}
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
.page-bubble {
    width: 42px !important;
    height: 42px !important;
    border-radius: 50% !important;
    border: 1px solid #d7d7d7 !important;
    display: inline-flex !important;
    justify-content: center !important;
    align-items: center !important;
    font-size: 14px !important;
    background: #fff !important;
    color: #333 !important;
    text-decoration: none !important;
    transition: 0.2s !important;
    margin: 0 2px !important;   /* <-- diperkecil dari 4px ke 2px */
    padding: 0 !important;      /* <-- agar benar2 rapat */
}

.page-bubble:hover {
    background: #f3f3f3 !important;
}

.page-bubble.active {
    background: #1669ff !important;
    color: #fff !important;
    border-color: #1669ff !important;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15) !important;
}

.page-bubble.disabled {
    opacity: .4 !important;
    cursor: not-allowed !important;
    background: #f3f3f3 !important;
}

</style>
@endpush

