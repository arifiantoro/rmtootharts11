@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Edit Data Perawatan</h4>

    <div class="alert alert-primary">
        <strong>Pasien:</strong> {{ $pasien->nama }}<br>
        <strong>Dokter Penanggung Jawab:</strong> {{ $dokter->nama }}
    </div>

    <form action="{{ route('perawatan.update', $perawatan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Tanggal Perawatan</label>
            <input type="date" name="tanggal_perawatan" value="{{ $perawatan->tanggal_perawatan }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Perawatan</label>
            <textarea name="catatan_perawatan" class="form-control" rows="3">{{ $perawatan->catatan_perawatan }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Dokter</label>
            <textarea name="catatan_dokter" class="form-control" rows="3">{{ $perawatan->catatan_dokter }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Jadwal Perawatan Berikutnya</label>
            <input type="date" name="jadwal_perawatan_selanjutnya" value="{{ $perawatan->jadwal_perawatan_selanjutnya }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        <a href="{{ route('perawatan.index', $rekamMedis->id) }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
