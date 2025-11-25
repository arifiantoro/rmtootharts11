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
        return $this->hasMany(RekamMedis::class);
    }

    public function perawatans()
{
    return $this->hasManyThrough(
        Perawatan::class,
        RekamMedis::class,
        'pasien_id',
        'rekam_medis_id',
        'id',
        'id'
    );
}

// Perawatan terbaru (tanpa latestOfMany)
public function latestPerawatan()
{
    return $this->perawatans()->orderByDesc('id')->first();
}


    // AMBIL REKAM MEDIS TERBARU (INI BOLEH latestOfMany)
    public function rekamMedisTerbaru()
    {
        return $this->hasOne(RekamMedis::class)->latestOfMany();
    }

    // AMBIL REKAM MEDIS TERAKHIR (alias saja)
    public function rekamMedisTerakhir()
    {
        return $this->hasOne(RekamMedis::class)->latestOfMany();
    }
    

    // AMBIL PERAWATAN TERAKHIR (manual, TIDAK PAKAI latestOfMany)
    // public function latestPerawatan()
    // {
    //     return $this->perawatans()->orderByDesc('id')->first(); // ✔ cara yang benar
    // }
}
