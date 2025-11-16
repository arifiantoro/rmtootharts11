@extends('layouts.app')

@section('content')
<div class="row mb-4">
  <div class="ms-3">
    <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
    <p class="mb-4 text-muted">Data Rekam Medis Klinik</p>
  </div>
</div>

<div class="row g-3">
  <!-- Card: Periksa -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-capitalize text-muted">Perawatan</p>
            <h4 class="mb-0">{{ $totalPerawatan }}</h4>
          </div>
          <div class="icon icon-md bg-gradient-dark text-white rounded-circle d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">weekend</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card: Pasien -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-capitalize text-muted">Pasien</p>
            <h4 class="mb-0">{{ $totalPasien }}</h4>
          </div>
          <div class="icon icon-md bg-gradient-dark text-white rounded-circle d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">groups</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card: Transaksi -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-capitalize text-muted">Transaksi</p>
            <h4 class="mb-0">~</h4>
          </div>
          <div class="icon icon-md bg-gradient-dark text-white rounded-circle d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">leaderboard</i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Card: Stok -->
  <div class="col-xl-3 col-sm-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <p class="text-sm mb-1 text-capitalize text-muted">Stok Barang</p>
            <h4 class="mb-0">{{ $totalStok }}</h4>
          </div>
          <div class="icon icon-md bg-gradient-dark text-white rounded-circle d-flex align-items-center justify-content-center">
            <i class="material-symbols-rounded opacity-10">inventory_2</i>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Card: Pasien Kontrol Hari Ini -->
<div class="col-xl-3 col-sm-6">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <p class="text-sm mb-1 text-capitalize text-muted">Kontrol Hari Ini</p>
          <h4 class="mb-0">{{ $pasienKontrolHariIni }}</h4>
        </div>
        <div class="icon icon-md bg-gradient-dark text-white rounded-circle d-flex align-items-center justify-content-center">
          <i class="material-symbols-rounded opacity-10">event_available</i>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Card: Ulang Tahun Hari Ini -->
<div class="col-xl-3 col-sm-6">
  <div class="card border-0 shadow-sm">
    <div class="card-body p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <p class="text-sm mb-1 text-capitalize text-muted">Ulang Tahun Hari Ini</p>
          <h4 class="mb-0">{{ $pasienUlangTahunHariIni }}</h4>
        </div>
        <div class="icon icon-md bg-gradient-dark text-white rounded-circle d-flex align-items-center justify-content-center">
          <i class="material-symbols-rounded opacity-10">cake</i>
        </div>
      </div>
    </div>
  </div>
</div>

</div>

{{-- Optional Chart Section --}}
<div class="row mt-4">
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h6 class="mb-2">Transaksi</h6>
        <canvas id="chart-bars" height="150"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h6 class="mb-2">Pasien</h6>
        <canvas id="chart-line" height="150"></canvas>
      </div>
    </div>
  </div>
  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h6 class="mb-2">Keuangan</h6>
        <canvas id="chart-line-tasks" height="150"></canvas>
      </div>
    </div>
  </div>
</div>
@endsection
