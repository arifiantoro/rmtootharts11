@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Tambah Rekam Medis</h1>

    <form action="{{ route('rekammedis.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                {{-- Pasien --}}
                <div class="form-group mb-3">
                    <label class="form-label">Nama Pasien</label>
                    <input type="text" class="form-control" value="{{ $pasien->nama }}" readonly>
                    <input type="hidden" name="pasien_id" value="{{ $pasien->id }}">
                </div>

                {{-- Dokter --}}
                <div class="form-group mb-3">
                    <label class="form-label">Dokter Penanggung Jawab</label>
                    <select name="dokter_id" class="form-control" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($dokters as $dokter)
                            <option value="{{ $dokter['id'] }}">{{ $dokter['nama'] }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tanggal --}}
                <div class="form-group mb-3">
                    <label class="form-label">Tanggal Periksa</label>
                    <input type="date" name="tanggal_perawatan" class="form-control" required>
                </div>

                {{-- Kondisi --}}
                <div class="form-group mb-3">
                    <label class="form-label">Kondisi</label><br>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="hamil" name="kondisi[]" value="Hamil" class="form-check-input">
                        <label class="form-check-label" for="hamil">Hamil</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" id="mag" name="kondisi[]" value="Mag" class="form-check-input">
                        <label class="form-check-label" for="mag">Mag</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                

                {{-- Alergi --}}
                <div class="form-group mb-3">
                    <label class="form-label">Alergi</label>
                    <input type="text" name="alergi" class="form-control">
                </div>

                {{-- Riwayat Penyakit --}}
                <div class="form-group mb-3">
                    <label class="form-label">Riwayat Penyakit</label>
                    <input type="text" name="riwayat_penyakit" class="form-control">
                </div>

                {{-- Catatan --}}
                <div class="form-group mb-3">
                    <label class="form-label">Catatan Khusus</label>
                    <textarea name="catatan_khusus" class="form-control" rows="1"></textarea>
                </div>

                {{-- Rencana Perawatan --}}
                <div class="form-group mb-3">
                    <label class="form-label">Rencana Perawatan</label>
                    <textarea name="rencana_perawatan" class="form-control" rows="2" required></textarea>
                </div>

            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
            <a href="{{ route('rekammedis.index') }}" class="btn btn-secondary">⬅️ Kembali</a>
        </div>
    </form>
</div>
@endsection
