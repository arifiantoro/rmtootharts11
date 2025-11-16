@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">🔔 Reminder</h4>

    {{-- Filter --}}
    <div class="mb-3">
        <a href="{{ route('reminder.index', ['filter' => 'today']) }}" class="btn btn-sm {{ $filter == 'today' ? 'btn-primary' : 'btn-outline-primary' }}">Hari Ini</a>
        <a href="{{ route('reminder.index', ['filter' => '3days']) }}" class="btn btn-sm {{ $filter == '3days' ? 'btn-primary' : 'btn-outline-primary' }}">3 Hari Ke Depan</a>
        <a href="{{ route('reminder.index', ['filter' => '7days']) }}" class="btn btn-sm {{ $filter == '7days' ? 'btn-primary' : 'btn-outline-primary' }}">7 Hari Ke Depan</a>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs" id="reminderTabs" role="tablist">
        <li class="nav-item">
            <button class="nav-link active" id="kontrol-tab" data-bs-toggle="tab" data-bs-target="#kontrol" type="button" role="tab">🩺 Jadwal Kontrol</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" id="ulangtahun-tab" data-bs-toggle="tab" data-bs-target="#ulangtahun" type="button" role="tab">🎂 Ulang Tahun</button>
        </li>
    </ul>

    <div class="tab-content mt-3" id="reminderTabsContent">
        {{-- Tab Jadwal Kontrol --}}
        <div class="tab-pane fade show active" id="kontrol" role="tabpanel">
            @if($kontrols->isEmpty())
                <p class="text-muted">Tidak ada jadwal kontrol dalam periode ini.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Pasien</th>
                            <th>Tanggal Kontrol</th>
                            <th>Dokter</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kontrols as $k)
                            <tr>
                                <td>{{ $k->rekamMedis->pasien->nama ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($k->jadwal_perawatan_selanjutnya)->format('d M Y') }}</td>
                                <td>{{ $k->rekamMedis->dokter->nama ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('perawatan.index', $k->rekamMedis->pasien_id) }}" class="btn btn-sm btn-outline-primary">Lihat Rekam Medis</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Tab Ulang Tahun --}}
        <div class="tab-pane fade" id="ulangtahun" role="tabpanel">
            @if($birthdays->isEmpty())
                <p class="text-muted">Tidak ada pasien yang berulang tahun dalam periode ini.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Tanggal Lahir</th>
                            <th>No. Telepon</th>
                        </tr>
                    </thead>
                    <tbody>
    @foreach($birthdays as $b)
        <tr>
            <td>{{ $b->nama }}</td>
            <td>{{ \Carbon\Carbon::parse($b->tanggal_lahir)->format('d M') }}</td>
            <td>
                @if($b->nomor_hp)
                    @php
                        // pastikan format nomor diawali 62 (kode negara)
                        $nomor = preg_replace('/^0/', '62', preg_replace('/\D/', '', $b->nomor_hp));
                    @endphp
                    <a href="https://wa.me/{{ $nomor }}" target="_blank" class="text-success fw-bold">
                        <i class="bi bi-whatsapp"></i> {{ $b->nomor_hp }}
                    </a>
                        @else
                        -
                        @endif
                       </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
