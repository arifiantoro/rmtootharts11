<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_keuangans';

    protected $fillable = [
        'tanggal',
        'kategori',
        'keterangan',
        'debit',
        'kredit',
        'metode_pembayaran',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'debit' => 'decimal:2',
        'kredit' => 'decimal:2',
    ];

    public function getFormattedDebitAttribute()
    {
        return $this->debit > 0 ? 'Rp ' . number_format($this->debit, 0, ',', '.') : '-';
    }

    public function getFormattedKreditAttribute()
    {
        return $this->kredit > 0 ? 'Rp ' . number_format($this->kredit, 0, ',', '.') : '-';
    }
}

