<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\TransaksiKeuangan;
use Illuminate\Http\Request;

class TransaksiKeuanganController extends Controller
{
    // 🧾 INDEX - Tampilkan daftar transaksi
    public function index(Request $request)
    {
        // Ambil parameter filter dari request
        $filter = $request->get('filter', 'bulan_ini'); // default bulan ini

        // Tentukan rentang tanggal
        switch ($filter) {
            case '6_bulan':
                $start = Carbon::now()->subMonths(6)->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;

            case 'tahun_ini':
                $start = Carbon::now()->startOfYear();
                $end = Carbon::now()->endOfYear();
                break;

            default:
                // Bulan ini
                $start = Carbon::now()->startOfMonth();
                $end = Carbon::now()->endOfMonth();
                break;
        }

        // Ambil transaksi sesuai rentang
        $transaksis = TransaksiKeuangan::whereBetween('tanggal', [$start, $end])
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung total debit, kredit, dan saldo akhir
        $totalDebit = $transaksis->sum('debit');
        $totalKredit = $transaksis->sum('kredit');
        $saldo = $totalDebit - $totalKredit;

        return view('transaksi_keuangan.index', compact('transaksis', 'totalDebit', 'totalKredit', 'saldo', 'filter', 'start', 'end'));
    }

        // ➕ CREATE - Form tambah transaksi
        public function create()
    {
        return view('transaksi_keuangan.create');
    }

    // 💾 STORE - Simpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pendapatan,Pengeluaran',
            'kategori' => 'required|in:Pendapatan,Gaji,Listrik,Internet,PDAM,Iuran RT RW,Operasional',
            'keterangan' => 'nullable|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:Cash,Transfer,QRIS,Lainnya',
        ]);

        // Tentukan arah transaksi
        $debit = $request->jenis === 'Pendapatan' ? $request->nominal : 0;
        $kredit = $request->jenis === 'Pengeluaran' ? $request->nominal : 0;

        // Simpan ke database
        TransaksiKeuangan::create([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'debit' => $debit,
            'kredit' => $kredit,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('transaksi-keuangan.index')
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    // ✏️ EDIT - Form edit transaksi
    public function edit($id)
    {
        $transaksi = TransaksiKeuangan::findOrFail($id);
        return view('transaksi_keuangan.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pendapatan,Pengeluaran',
            'kategori' => 'required|in:Pendapatan,Gaji,Listrik,Internet,PDAM,Iuran RT RW,Operasional',
            'keterangan' => 'nullable|string|max:255',
            'nominal' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:Cash,Transfer,QRIS,Lainnya',
        ]);

        $transaksi = TransaksiKeuangan::findOrFail($id);

        // Tentukan debit/kredit baru
        $debit = $request->jenis === 'Pendapatan' ? $request->nominal : 0;
        $kredit = $request->jenis === 'Pengeluaran' ? $request->nominal : 0;

        $transaksi->update([
            'tanggal' => $request->tanggal,
            'kategori' => $request->kategori,
            'keterangan' => $request->keterangan,
            'debit' => $debit,
            'kredit' => $kredit,
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        return redirect()->route('transaksi-keuangan.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }
}
