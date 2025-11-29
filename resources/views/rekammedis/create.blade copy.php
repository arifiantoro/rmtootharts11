@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Rekam Medis + Odontogram</h1>

    <form action="{{ route('rekammedis.store') }}" method="POST">
        @csrf

        {{-- === Bagian Data Umum === --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Nama Pasien</label>
                    <input type="text" class="form-control" value="{{ $pasien->nama }}" readonly>
                    <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                </div>
                <div class="form-group mb-3">
                    <label>Dokter</label>
                    <select name="dokter_id" class="form-control" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter['id'] }}">{{ $dokter['nama'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label>Tanggal Periksa</label>
                    <input type="date" name="tanggal_perawatan" class="form-control" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label>Rencana Perawatan</label>
                    <textarea name="rencana_perawatan" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <hr>

    {{-- ====== Odontogram Section ====== --}}
    <div class="odontogram-container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>🦷 Odontogram</h4>
            <div>
                <button type="button" id="btnDewasa" class="btn btn-sm btn-primary">Dewasa</button>
                <button type="button" id="btnAnak" class="btn btn-sm btn-outline-primary">Anak</button>
            </div>
        </div>

        {{-- ================= ODONTOGRAM DEWASA ================= --}}
        <div id="odontogramDewasa">
            <h5 class="text-center mb-2">Odontogram Dewasa</h5>

            {{-- Label Kuadran Atas --}}
            <div class="d-flex justify-content-between mb-2 px-5">
                <span>Kuadran 1 (Kanan Atas)</span>
                <span>Kuadran 2 (Kiri Atas)</span>
            </div>

            {{-- Rahang Atas --}}
            <div class="d-flex justify-content-center gap-5 mb-4">
                {{-- Kuadran 1 --}}
                <div class="d-flex flex-row-reverse gap-1">
                    @for($i = 18; $i >= 11; $i--)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
                {{-- Kuadran 2 --}}
                <div class="d-flex flex-row gap-1">
                    @for($i = 21; $i <= 28; $i++)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
            </div>

            {{-- Label Kuadran Bawah --}}
            <div class="d-flex justify-content-between mb-2 px-5">
                <span>Kuadran 4 (Kanan Bawah)</span>
                <span>Kuadran 3 (Kiri Bawah)</span>
            </div>

            {{-- Rahang Bawah --}}
            <div class="d-flex justify-content-center gap-5">
                {{-- Kuadran 4 --}}
                <div class="d-flex flex-row-reverse gap-1">
                    @for($i = 48; $i >= 41; $i--)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
                {{-- Kuadran 3 --}}
                <div class="d-flex flex-row gap-1">
                    @for($i = 31; $i <= 38; $i++)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- ================= ODONTOGRAM ANAK ================= --}}
        <div id="odontogramAnak" class="d-none">
            <h5 class="text-center mb-2">Odontogram Anak</h5>

            <div class="d-flex justify-content-between mb-2 px-5">
                <span>Kuadran 5 (Kanan Atas)</span>
                <span>Kuadran 6 (Kiri Atas)</span>
            </div>

            <div class="d-flex justify-content-center gap-5 mb-4">
                {{-- Kuadran 5 --}}
                <div class="d-flex flex-row-reverse gap-1">
                    @for($i = 55; $i >= 51; $i--)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
                {{-- Kuadran 6 --}}
                <div class="d-flex flex-row gap-1">
                    @for($i = 61; $i <= 65; $i++)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
            </div>

            <div class="d-flex justify-content-between mb-2 px-5">
                <span>Kuadran 8 (Kanan Bawah)</span>
                <span>Kuadran 7 (Kiri Bawah)</span>
            </div>

            <div class="d-flex justify-content-center gap-5">
                {{-- Kuadran 8 --}}
                <div class="d-flex flex-row-reverse gap-1">
                    @for($i = 85; $i >= 81; $i--)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
                {{-- Kuadran 7 --}}
                <div class="d-flex flex-row gap-1">
                    @for($i = 71; $i <= 75; $i++)
                        <div class="tooth" data-id="{{ $i }}">{{ $i }}</div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- LEGEND --}}
        <div class="mt-4">
            <h6>Keterangan Warna:</h6>
            <div class="d-flex flex-wrap gap-3">
                <div><span class="legend karies"></span> Karies / Patah</div>
                <div><span class="legend hilang"></span> Hilang</div>
                <div><span class="legend belum-erupsi"></span> Belum Erupsi</div>
                <div><span class="legend karang-gigi"></span> Karang Gigi</div>
                <div><span class="legend sisa-akar"></span> Sisa Akar</div>
            </div>
        </div>
    </div>

    

    {{-- MODAL STATUS --}}
    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Pilih Status Gigi</h5></div>
                <div class="modal-body">
                    <select id="toothStatus" class="form-select">
                        <option value="">-- Pilih Status --</option>
                        <option value="karies">Karies / Patah</option>
                        <option value="hilang">Hilang</option>
                        <option value="belum-erupsi">Belum Erupsi</option>
                        <option value="karang-gigi">Karang Gigi</option>
                        <option value="sisa-akar">Sisa Akar</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" id="saveStatus" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>

        <hr class="my-4">

        {{-- Tombol Simpan dan Reset --}}
        <div class="text-end">
            <button type="button" id="resetOdontogram" class="btn btn-warning me-2">
                🔄 Reset Odontogram
            </button>
            <button type="submit" class="btn btn-success">
                💾 Simpan Rekam Medis
            </button>
        </div>
    </form>
</div>

<style>
.tooth {
    width: 28px;
    height: 28px;
    border: 1px solid #000;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 10px;
    border-radius: 4px;
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

<script>
let selectedTooth = null;

// Klik gigi → buka modal
document.querySelectorAll('.tooth').forEach(t => {
    t.addEventListener('click', () => {
        selectedTooth = t;
        document.getElementById('toothStatus').value = ""; // reset dropdown
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    });
});

// Simpan status gigi
document.getElementById('saveStatus').addEventListener('click', () => {
    const status = document.getElementById('toothStatus').value;
    if (selectedTooth) {
        selectedTooth.className = 'tooth'; // reset dulu
        if (status && status !== 'reset') selectedTooth.classList.add(status);
    }
    bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
});

// Toggle anak / dewasa
document.getElementById('btnDewasa').addEventListener('click', () => {
    document.getElementById('odontogramDewasa').classList.remove('d-none');
    document.getElementById('odontogramAnak').classList.add('d-none');
    document.getElementById('btnDewasa').classList.add('btn-primary');
    document.getElementById('btnAnak').classList.remove('btn-primary');
});

document.getElementById('btnAnak').addEventListener('click', () => {
    document.getElementById('odontogramAnak').classList.remove('d-none');
    document.getElementById('odontogramDewasa').classList.add('d-none');
    document.getElementById('btnAnak').classList.add('btn-primary');
    document.getElementById('btnDewasa').classList.remove('btn-primary');
});

// Tombol Reset Odontogram
document.getElementById('resetOdontogram').addEventListener('click', () => {
    if (confirm("Yakin ingin menghapus semua warna/status gigi?")) {
        document.querySelectorAll('.tooth').forEach(t => t.className = 'tooth');
    }
});

// Saat form disubmit → kumpulkan data odontogram
document.querySelector('form').addEventListener('submit', () => {
    // Hapus input hidden odontogram lama (agar tidak dobel)
    document.querySelectorAll('input[name^="odontogram["]').forEach(el => el.remove());

    // Loop semua gigi yang punya status (class tambahan selain .tooth)
    document.querySelectorAll('.tooth').forEach((tooth, index) => {
        const classes = Array.from(tooth.classList).filter(c => c !== 'tooth');
        if (classes.length > 0) {
            const status = classes[0];
            const tipe = document.getElementById('odontogramAnak').classList.contains('d-none')
                ? 'dewasa'
                : 'anak';

            // Tambahkan input hidden untuk nomor gigi, status, dan tipe
            ['nomor_gigi', 'status', 'tipe'].forEach((field, i) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = `odontogram[${index}][${field}]`;
                if (field === 'nomor_gigi') input.value = tooth.dataset.id;
                if (field === 'status') input.value = status;
                if (field === 'tipe') input.value = tipe;
                document.querySelector('form').appendChild(input);
            });
        }
    });
});

</script>
@endsection
