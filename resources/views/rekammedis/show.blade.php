@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Header dengan tombol Edit --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Rekam Medis</h1>

        <a href="{{ route('rekammedis.edit', $rekamMedis->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil-square"></i> Edit Rekam Medis
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>Data Pasien</h5>
            <p><strong>Nama:</strong> {{ $rekamMedis->pasien->nama }}</p>
            <p><strong>No. Register:</strong> {{ $rekamMedis->pasien->noreg }}</p>
            <p><strong>Dokter:</strong> {{ $rekamMedis->dokter->nama ?? '-' }}</p>
            <p><strong>Tanggal Periksa:</strong> {{ $rekamMedis->tanggal_perawatan }}</p>
            <p><strong>Rencana Perawatan:</strong> {{ $rekamMedis->rencana_perawatan }}</p>
        </div>
    </div>

    {{-- ================== ODONTOGRAM ================== --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="text-center mb-4">🦷 Odontogram Pasien</h4>

            @php
                $odontogram = $rekamMedis->odontogram ?? collect();
                $dewasa = $odontogram->whereBetween('nomor_gigi', [11, 48]);
                $anak = $odontogram->whereBetween('nomor_gigi', [51, 85]);
            @endphp

            @if($dewasa->count() > 0)
                {{-- ================= ODONTOGRAM DEWASA ================= --}}
                <h6 class="text-center mb-2">Odontogram Dewasa</h6>

                {{-- Label Kuadran Atas --}}
                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 1 (Kanan Atas)</span>
                    <span>Kuadran 2 (Kiri Atas)</span>
                </div>

                {{-- Rahang Atas --}}
                <div class="d-flex justify-content-center gap-4 mb-4">
                    {{-- Kuadran 1 --}}
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 18; $i >= 11; $i--)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>

                    {{-- Kuadran 2 --}}
                    <div class="d-flex flex-row gap-1">
                        @for($i = 21; $i <= 28; $i++)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>

                {{-- Label Kuadran Bawah --}}
                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 4 (Kanan Bawah)</span>
                    <span>Kuadran 3 (Kiri Bawah)</span>
                </div>

                {{-- Rahang Bawah --}}
                <div class="d-flex justify-content-center gap-4 mb-4">
                    {{-- Kuadran 4 --}}
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 48; $i >= 41; $i--)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>

                    {{-- Kuadran 3 --}}
                    <div class="d-flex flex-row gap-1">
                        @for($i = 31; $i <= 38; $i++)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>
            @endif

            @if($anak->count() > 0)
                {{-- ================= ODONTOGRAM ANAK ================= --}}
                <hr class="my-4">
                <h6 class="text-center mb-2">Odontogram Anak</h6>

                {{-- Label Kuadran Atas --}}
                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 5 (Kanan Atas)</span>
                    <span>Kuadran 6 (Kiri Atas)</span>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-4">
                    {{-- Kuadran 5 --}}
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 55; $i >= 51; $i--)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>

                    {{-- Kuadran 6 --}}
                    <div class="d-flex flex-row gap-1">
                        @for($i = 61; $i <= 65; $i++)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>

                {{-- Label Kuadran Bawah --}}
                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 8 (Kanan Bawah)</span>
                    <span>Kuadran 7 (Kiri Bawah)</span>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-4">
                    {{-- Kuadran 8 --}}
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 85; $i >= 81; $i--)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>

                    {{-- Kuadran 7 --}}
                    <div class="d-flex flex-row gap-1">
                        @for($i = 71; $i <= 75; $i++)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>
            @endif

            @if($dewasa->count() === 0 && $anak->count() === 0)
                <p class="text-center text-muted">Belum ada data odontogram untuk pasien ini.</p>
            @endif

            {{-- LEGEND --}}
            <hr>
            <div class="mt-3">
                <h6 class="fw-bold text-muted">Keterangan Warna:</h6>
                <div class="d-flex flex-wrap gap-3">
                    <div><span class="legend karies"></span> Karies / Patah</div>
                    <div><span class="legend hilang"></span> Hilang</div>
                    <div><span class="legend belum-erupsi"></span> Belum Erupsi</div>
                    <div><span class="legend karang-gigi"></span> Karang Gigi</div>
                    <div><span class="legend sisa-akar"></span> Sisa Akar</div>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('rekammedis.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
            </div>
        </div>
    </div>
</div>

<style>
.tooth {
    width: 35px;
    height: 35px;
    border: 1px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    border-radius: 6px;
    user-select: none;
    transition: all 0.2s ease;
}
.legend {
    width: 18px;
    height: 18px;
    display: inline-block;
    border-radius: 4px;
    margin-right: 6px;
}
.karies { background-color: #e74c3c !important; color: white; }
.hilang { background-color: #34495e !important; color: white; }
.belum-erupsi { background-color: #f1c40f !important; }
.karang-gigi { background-color: #27ae60 !important; color: white; }
.sisa-akar { background-color: #8e44ad !important; color: white; }
</style>
@endsection
