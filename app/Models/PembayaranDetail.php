<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembayaran_id',
        'perawatan_id',
        'barang_id',
        'deskripsi',
        'jumlah',
        'harga_satuan',
        'diskon',
        'subtotal',
    ];

    // Relasi ke pembayaran
    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    // Relasi ke stok barang
    public function barang()
    {
        return $this->belongsTo(StokBarang::class, 'barang_id');
    }

    // Relasi ke perawatan
    public function perawatan()
    {
        return $this->belongsTo(\App\Models\Perawatan::class, 'perawatan_id', 'id');
    }

}
