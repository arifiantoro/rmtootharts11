<!-- resources/views/anggota/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Tambah Pasien</h1>
        <form action="{{ route('pasien.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    
                    <div class="form-group">
                        <label for="noreg">Nomor Register</label>
                        <input type="text" name="noreg" id="noreg" value="{{ old('noreg') }}"
                               class="form-control @error('noreg') is-invalid @enderror"
                               style="border: 1px solid #ccc; padding: 10px;" required>
                        @error('noreg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                               class="form-control @error('nama') is-invalid @enderror"
                               style="border: 1px solid #ccc; padding: 10px;" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                        {{-- Jenis Pasien --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Jenis Pasien</label>
                        <select name="jenis_pasien" class="form-control" required>
                            <option value="Ortho">Ortho</option>
                            <option value="Umum">Umum</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                               class="form-control @error('tempat_lahir') is-invalid @enderror"
                               style="border: 1px solid #ccc; padding: 10px;" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                               class="form-control @error('tanggal_lahir') is-invalid @enderror"
                               style="border: 1px solid #ccc; padding: 10px;" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin"
                                class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                style="border: 1px solid #ccc; padding: 10px;" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nomor_hp">Nomor HP/Whatsapp</label>
                        <input type="text" name="nomor_hp" id="nomor_hp" value="{{ old('nomor_hp') }}"
                               class="form-control @error('nomor_hp') is-invalid @enderror"
                               style="border: 1px solid #ccc; padding: 10px;" required>
                        @error('nomor_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Create</button>
        </form>
    </div>
@endsection


