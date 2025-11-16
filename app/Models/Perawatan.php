<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perawatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'rekam_medis_id',
        'dokter_id',
        'tanggal_perawatan',
        'catatan_perawatan',
        'catatan_dokter',
        'jadwal_perawatan_selanjutnya'
    ];

    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    
    public function pembayaran()
{
    return $this->hasOne(\App\Models\Pembayaran::class, 'perawatan_id');
}

    public function pembayaranDetails()
    {
        return $this->hasMany(\App\Models\PembayaranDetail::class, 'perawatan_id', 'id');
    }

}
