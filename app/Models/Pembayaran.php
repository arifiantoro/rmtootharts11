<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekam_medis_id',
        'perawatan_id',
        'tanggal_pembayaran',
        'total_tagihan',
        'total_bayar',
        'kembalian',
        'metode_pembayaran',
        'catatan',
    ];

    // Relasi: satu pembayaran milik satu rekam medis
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class, 'rekam_medis_id');
    }

        public function perawatan()
    {
        return $this->belongsTo(Perawatan::class, 'perawatan_id');
    }

    public function details()
    {
        return $this->hasMany(PembayaranDetail::class);
    }

}
