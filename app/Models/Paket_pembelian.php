<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket_pembelian extends Model
{
    use HasFactory;

    protected $table = 'paket_pembelian';

    protected $fillable = [
        'nama_paket',
        'kategori_id',
        'harga_paket',
        'gambar',
        'perlengkapan',
        'diskon',
        'keterangan',
    ];

    protected $casts = [
        'perlengkapan' => 'json',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_barang');
    }

}
