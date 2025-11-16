@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">Edit Rekam Medis</h1>

    {{-- ================== DATA PASIEN ================== --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Informasi Pasien</h5>
            <p><strong>Nama:</strong> {{ $rekamMedis->pasien->nama }}</p>
            <p><strong>No. Register:</strong> {{ $rekamMedis->pasien->noreg }}</p>
        </div>
    </div>

    {{-- ================== FORM REKAM MEDIS ================== --}}
    <form action="{{ route('rekammedis.update', $rekamMedis->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- === Bagian Data Umum === --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Data Pemeriksaan</h5>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Nama Pasien</label>
                            <input type="text" class="form-control" value="{{ $rekamMedis->pasien->nama }}" readonly>
                            <input type="hidden" name="pasien_id" value="{{ $rekamMedis->pasien_id }}">
                        </div>

                        <div class="form-group mb-3">
                            <label>Dokter</label>
                            <select name="dokter_id" class="form-control" required>
                                <option value="">-- Pilih Dokter --</option>
                                @foreach($dokters as $dokter)
                                    <option value="{{ $dokter['id'] }}"
                                        {{ $rekamMedis->dokter_id == $dokter['id'] ? 'selected' : '' }}>
                                        {{ $dokter['nama'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label>Tanggal Periksa</label>
                            <input type="date" name="tanggal_perawatan" class="form-control"
                                value="{{ old('tanggal_perawatan', $rekamMedis->tanggal_perawatan ? $rekamMedis->tanggal_perawatan->format('Y-m-d') : '') }}"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label>Rencana Perawatan</label>
                            <textarea name="rencana_perawatan" class="form-control" rows="3">{{ old('rencana_perawatan', $rekamMedis->rencana_perawatan) }}</textarea>
                        </div>
                    </div>
                </div>
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

                {{-- Odontogram Dewasa --}}
                <h6 class="text-center mb-2">Odontogram Dewasa</h6>
                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 1 (Kanan Atas)</span>
                    <span>Kuadran 2 (Kiri Atas)</span>
                </div>

                {{-- Rahang Atas --}}
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 18; $i >= 11; $i--)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
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
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 48; $i >= 41; $i--)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                    <div class="d-flex flex-row gap-1">
                        @for($i = 31; $i <= 38; $i++)
                            <div class="tooth {{ optional($dewasa->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>

                {{-- Odontogram Anak --}}
                <hr class="my-4">
                <h6 class="text-center mb-2">Odontogram Anak</h6>

                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 5 (Kanan Atas)</span>
                    <span>Kuadran 6 (Kiri Atas)</span>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-4">
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 55; $i >= 51; $i--)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                    <div class="d-flex flex-row gap-1">
                        @for($i = 61; $i <= 65; $i++)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-2 px-5 text-muted fw-semibold">
                    <span>Kuadran 8 (Kanan Bawah)</span>
                    <span>Kuadran 7 (Kiri Bawah)</span>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-4">
                    <div class="d-flex flex-row-reverse gap-1">
                        @for($i = 85; $i >= 81; $i--)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                    <div class="d-flex flex-row gap-1">
                        @for($i = 71; $i <= 75; $i++)
                            <div class="tooth {{ optional($anak->firstWhere('nomor_gigi', $i))->status }}" data-id="{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>
                </div>

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

                {{-- Hidden input untuk kirim odontogram --}}
                <input type="hidden" name="odontogram" id="odontogramInput">

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('rekammedis.show', $rekamMedis->id) }}" class="btn btn-secondary">⬅️ Kembali</a>
                    <button type="submit" class="btn btn-primary px-4">💾 Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ================== MODAL STATUS GIGI ================== --}}
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold" id="statusModalLabel">Pilih Status Gigi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <select id="toothStatus" class="form-select">
          <option value="">-- Pilih Status --</option>
          <option value="karies">Karies / Patah</option>
          <option value="hilang">Hilang</option>
          <option value="belum-erupsi">Belum Erupsi</option>
          <option value="karang-gigi">Karang Gigi</option>
          <option value="sisa-akar">Sisa Akar</option>
          <option value="reset">Reset / Normal</option>
        </select>
      </div>
      <div class="modal-footer">
        <button id="saveStatus" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- ================== STYLE DAN SCRIPT ================== --}}
<style>
.tooth { width: 35px; height: 35px; border: 1px solid #ccc; border-radius: 6px; text-align: center; line-height: 35px; cursor: pointer; font-size: 12px; }
.tooth:hover { background: #f0f8ff; }
.karies { background-color: #f87171 !important; }
.hilang { background-color: #9ca3af !important; }
.belum-erupsi { background-color: #60a5fa !important; }
.karang-gigi { background-color: #facc15 !important; }
.sisa-akar { background-color: #a78bfa !important; }
.legend { display:inline-block;width:18px;height:18px;border-radius:4px;margin-right:5px; }
.legend.karies {background-color:#f87171;}
.legend.hilang {background-color:#9ca3af;}
.legend.belum-erupsi {background-color:#60a5fa;}
.legend.karang-gigi {background-color:#facc15;}
.legend.sisa-akar {background-color:#a78bfa;}
</style>

@push('scripts')
<script>
let selectedTooth = null;
let odontogram = {};

// Inisialisasi status awal dari tampilan
document.querySelectorAll('.tooth').forEach(t => {
    const num = t.dataset.id;
    odontogram[num] = [...t.classList].find(c =>
        ["karies", "hilang", "belum-erupsi", "karang-gigi", "sisa-akar"].includes(c)
    ) || '';

    // Klik gigi → buka modal
    t.addEventListener('click', () => {
        selectedTooth = t;
        document.getElementById('toothStatus').value = odontogram[num] || '';
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    });
});

// Simpan status dari modal
document.getElementById('saveStatus').addEventListener('click', () => {
    const status = document.getElementById('toothStatus').value;
    if (selectedTooth) {
        const num = selectedTooth.dataset.id;
        selectedTooth.className = 'tooth';
        if (status && status !== 'reset') selectedTooth.classList.add(status);
        odontogram[num] = (status === 'reset') ? '' : status;
    }
    bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
});

// Saat submit form → ubah jadi JSON dan masukkan ke input hidden
document.querySelector("form").addEventListener("submit", function(e) {
    const odontogramArray = Object.keys(odontogram)
        .filter(num => odontogram[num]) // hanya gigi dengan status
        .map(num => ({
            nomor_gigi: num,
            status: odontogram[num],
            tipe: (num < 50 ? "dewasa" : "anak"),
        }));

    // hapus input lama kalau ada
    this.querySelectorAll("input[name='odontogram']").forEach(el => el.remove());

    // buat input baru
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "odontogram";
    input.value = JSON.stringify(odontogramArray);
    this.appendChild(input);
});
</script>
@endpush

@endsection
