<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Carbon\Carbon;

class FollowUpController extends Controller
{
    public function index()
    {
        $sixMonthsAgo = Carbon::today()->subMonths(6);

        /**
         * SUBQUERY: ID perawatan terakhir per pasien
         */
        $latestPerawatanSub = function ($query) {
            $query->selectRaw('MAX(p2.id)')
                ->from('perawatans as p2')
                ->join('rekam_medis as rm2', 'rm2.id', '=', 'p2.rekam_medis_id')
                ->whereColumn('rm2.pasien_id', 'pasiens.id');
        };

        /*
        |--------------------------------------------------------------------------
        | A. PASIEN TANPA PERAWATAN (0 perawatan)
        |--------------------------------------------------------------------------
        */
        $zeroPerawatan = Pasien::whereDoesntHave('rekamMedis.perawatans')
            ->orderBy('nama')
            ->paginate(10, ['*'], 'zero');


        /*
        |--------------------------------------------------------------------------
        | B. PERAWATAN TERAKHIR TANPA JADWAL NEXT (Perawatan Aktif)
        |--------------------------------------------------------------------------
        */
        $perawatanAktif = Pasien::whereHas('rekamMedis.perawatans', function ($q) use ($latestPerawatanSub) {
                $q->whereIn('perawatans.id', $latestPerawatanSub)
                  ->whereNull('jadwal_perawatan_selanjutnya'); // kolom yang benar
            })
            ->orderBy('nama')
            ->paginate(10, ['*'], 'aktif');


        /*
        |--------------------------------------------------------------------------
        | C. PERAWATAN TERAKHIR > 6 BULAN LALU (Follow Up)
        |--------------------------------------------------------------------------
        */
        $selesaiLama = Pasien::whereHas('rekamMedis.perawatans', function ($q) use ($latestPerawatanSub, $sixMonthsAgo) {
                $q->whereIn('perawatans.id', $latestPerawatanSub)
                  ->whereDate('tanggal_perawatan', '<=', $sixMonthsAgo); // kolom yang benar
            })
            ->orderBy('nama')
            ->paginate(10, ['*'], 'selesai');


        return view('followup.index', compact(
            'zeroPerawatan',
            'perawatanAktif',
            'selesaiLama'
        ));
    }
}
