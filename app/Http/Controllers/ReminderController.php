<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Perawatan;
use Carbon\Carbon;

class ReminderController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today'); // default hari ini
        $today = Carbon::today();

        // Tentukan rentang waktu filter
        switch ($filter) {
            case '3days':
                $endDate = $today->copy()->addDays(3);
                break;
            case '7days':
                $endDate = $today->copy()->addDays(7);
                break;
            default:
                $endDate = $today;
                break;
        }

        /**
         * 🩺 Reminder Jadwal Kontrol
         * Ambil perawatan yang jadwal selanjutnya antara hari ini - X hari ke depan
         */
        $kontrols = Perawatan::with(['rekamMedis.pasien'])
            ->whereBetween('jadwal_perawatan_selanjutnya', [$today, $endDate])
            ->orderBy('jadwal_perawatan_selanjutnya', 'asc')
            ->get();

        /**
         * 🎂 Reminder Ulang Tahun
         * Ambil pasien yang berulang tahun dalam range waktu filter
         */
        $birthdays = Pasien::select('id', 'nama', 'tanggal_lahir', 'nomor_hp')
            ->get()
            ->filter(function ($pasien) use ($today, $endDate) {
                if (!$pasien->tanggal_lahir) return false;

                $birthday = Carbon::parse($pasien->tanggal_lahir)->setYear($today->year);
                return $birthday->between($today, $endDate);
            })
            ->sortBy('tanggal_lahir');

        return view('reminder.index', compact('kontrols', 'birthdays', 'filter'));
    }
}
