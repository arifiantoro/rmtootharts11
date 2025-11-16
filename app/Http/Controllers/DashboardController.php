<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Perawatan;
use App\Models\StokBarang;
use App\Models\RekamMedis;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPasien = Pasien::count();
        $totalPerawatan = Perawatan::count();
        $totalStok = StokBarang::count(); 

        $pasienKontrolHariIni = Perawatan::whereDate('jadwal_perawatan_selanjutnya', today())
        ->distinct('rekam_medis_id')
        ->count('rekam_medis_id');

        $pasienUlangTahunHariIni = Pasien::whereMonth('tanggal_lahir', now()->month)
        ->whereDay('tanggal_lahir', now()->day)
        ->count();

        return view('welcome', compact(
        'totalPasien',
        'totalPerawatan',
        'totalStok',
        'pasienKontrolHariIni',
        'pasienUlangTahunHariIni'
        ));
    }
}
