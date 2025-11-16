<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasiens';

    protected $fillable = [
        'noreg',
        'nama',
        'jenis_pasien',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nomor_hp',
    ];

    public function rekamMedis()
    {
        return $this->hasMany(\App\Models\RekamMedis::class);
    }

    public function perawatans()
    {
        return $this->hasManyThrough(
            \App\Models\Perawatan::class,   // model tujuan
            \App\Models\RekamMedis::class,  // model perantara
            'pasien_id',                    // foreign key di rekam_medis
            'rekam_medis_id',               // foreign key di perawatans
            'id',                           // local key di pasiens
            'id'                            // local key di rekam_medis
        );
    }

    public function rekamMedisTerakhir()
    {
      return $this->hasOne(RekamMedis::class)->latestOfMany();
    }


}

