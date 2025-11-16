<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'alergi',
        'hamil',
        'mag',
        'riwayat_penyakit',
        'catatan_khusus',
        'keterangan_karies',
        'gigi_hilang',
        'sisa_akar',
        'belum_erupsi',
        'karang_gigi',
        'jenis_pasien'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function perawatans()
    {
        return $this->hasMany(Perawatan::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'rekam_medis_id');
    }

        public function odontogram()
    {
        return $this->hasMany(\App\Models\Odontogram::class, 'rekam_medis_id');
    }

}
