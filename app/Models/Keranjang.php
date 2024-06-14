<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'id_user',
        'id_barang',
        'harga_barang',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function paket_pembelian() {
        return $this->belongsTo(Paket_pembelian::class, 'id_barang');
    }

    public function transaksi(){
        return $this->hasMany(Transaksi::class, 'id_keranjang');
    }
}
