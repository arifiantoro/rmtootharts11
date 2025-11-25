<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    PasienKlinikController,
    RekamMedisController,
    PerawatanController,
    PembayaranController,
    PembayaranDetailController,
    ReminderController,
    TransaksiKeuanganController,
    OdontogramController,
    StokBarangController,
    FollowUpController
};

// =======================
// 🔹 Dashboard
// =======================
Route::get('/', [DashboardController::class, 'index'])->name('welcome');
Route::view('/pos', 'pos');

// =======================
// 🔹 Pasien
// =======================
Route::resource('pasien', PasienKlinikController::class);

// =======================
// 🔹 Rekam Medis
// =======================
// Resource utama (index, show, edit, update, destroy)
Route::resource('rekammedis', RekamMedisController::class);

// Override create agar punya parameter pasien_id
Route::get('/rekammedis/create/{pasien_id}', [RekamMedisController::class, 'create'])
    ->name('rekammedis.create');


// =======================
// 🔹 Perawatan
// =======================
Route::prefix('perawatan')->group(function () {
    Route::get('/{pasien_id}', [PerawatanController::class, 'index'])->name('perawatan.index');

    // CRUD Perawatan
    Route::get('/{rekamMedisId}/create', [PerawatanController::class, 'create'])->name('perawatan.create');
    Route::post('/{rekamMedisId}', [PerawatanController::class, 'store'])->name('perawatan.store');
    Route::get('/edit/{id}', [PerawatanController::class, 'edit'])->name('perawatan.edit');
    Route::put('/{id}', [PerawatanController::class, 'update'])->name('perawatan.update');

    // =======================
    // 🔹 Pembayaran
    // =======================
    Route::prefix('pembayaran')->group(function () {
        Route::get('/perawatan/{perawatanId}/create', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/perawatan/{perawatanId}', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::delete('/{id}', [PembayaranController::class, 'destroy'])->name('pembayaran.destroy');
        Route::get('/{id}/print', [PembayaranController::class, 'print'])->name('pembayaran.print');
    });

    // Detail pembayaran
    Route::post('/{pembayaranId}/detail', [PembayaranDetailController::class, 'store'])->name('pembayaran.detail.store');
    Route::delete('/detail/{id}', [PembayaranDetailController::class, 'destroy'])->name('pembayaran.detail.destroy');
});


// =======================
// 🔹 Odontogram
// =======================
Route::prefix('odontogram')->group(function () {
    Route::post('/store', [OdontogramController::class, 'store'])->name('odontogram.store');
    Route::delete('/{id}', [OdontogramController::class, 'destroy'])->name('odontogram.destroy');
    Route::get('/rekammedis/{id}', [OdontogramController::class, 'getByRekamMedis'])->name('odontogram.getByRekamMedis');
});


// =======================
// 🔹 Reminder & Keuangan
// =======================
Route::get('/reminder', [ReminderController::class, 'index'])->name('reminder.index');
Route::resource('stok-barang', StokBarangController::class);
Route::resource('transaksi-keuangan', TransaksiKeuanganController::class);

// =======================
// 🔹 Follow Up
// =======================
Route::get('/follow-up', [FollowUpController::class, 'index'])
    ->name('followup.index');
