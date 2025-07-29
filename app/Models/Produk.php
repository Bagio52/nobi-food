<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama_produk',
        'gambar',
        'harga',
        'waktu_pembuatan'
    ];

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class, 'id_produk');
    }
}
