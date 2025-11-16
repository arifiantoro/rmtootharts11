<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'stok',
        'harga_satuan',
        'keterangan',
    ];

    protected static function booted()
    {
        static::creating(function ($barang) {
            if (empty($barang->kode_barang)) {
                $latest = static::latest('id')->first();
                $nextNumber = $latest ? $latest->id + 1 : 1;
                $barang->kode_barang = 'BRG' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });

        // 🔒 Tambahkan ini
        static::updating(function ($barang) {
            unset($barang->kode_barang);
        });
    }

    public function pembayaranDetails()
    {
        return $this->hasMany(PembayaranDetail::class, 'barang_id');
    }
    
}

