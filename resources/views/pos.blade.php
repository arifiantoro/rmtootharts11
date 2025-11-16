@extends('layouts.app')

@section('content')
  <style>
  /* Efek hover card */
  .card-hover {
      transition: all 0.25s ease-in-out;
  }
  .card-hover:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
  }
</style>

<div class="row">
  <div class="col-12 mb-4 ms-3">
    <h3 class="mb-0 h4 font-weight-bolder">Point Of Sales</h3>
    <p class="mb-0">Data Stok Barang dan Transaksi</p>
  </div>

  <!-- Card Stok Barang -->
  <div class="col-xl-3 col-sm-6 mb-4">
    <a href="{{ route('stok-barang.index') }}" class="text-decoration-none">
      <div class="card card-hover shadow-sm border-0 h-100">
        <div class="card-header p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-sm mb-1 text-capitalize text-muted">Stok Barang</p>
              <h4 class="mb-0 fw-bold text-dark">277</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">box</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          {{-- <p class="mb-0 text-sm"><span class="text-success fw-bold">+55%</span> dari minggu lalu</p> --}}
        </div>
      </div>
    </a>
  </div>

  <!-- Card Transaksi -->
  <div class="col-xl-3 col-sm-6 mb-4">
    <a href="{{ route('transaksi-keuangan.index') }}" class="text-decoration-none">
      <div class="card card-hover shadow-sm border-0 h-100">
        <div class="card-header p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <p class="text-sm mb-1 text-capitalize text-muted">Transaksi</p>
              <h4 class="mb-0 fw-bold text-dark">2300</h4>
            </div>
            <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark text-center border-radius-lg">
              <i class="material-symbols-rounded opacity-10">leaderboard</i>
            </div>
          </div>
        </div>
        <hr class="dark horizontal my-0">
        <div class="card-footer p-2 ps-3">
          {{-- <p class="mb-0 text-sm"><span class="text-success fw-bold">+3%</span> dari bulan lalu</p> --}}
        </div>
      </div>
    </a>
  </div>
</div>

      
      
</div>
@endsection