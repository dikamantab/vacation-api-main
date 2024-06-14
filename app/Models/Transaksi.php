<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_keranjang',
        'bukti_pembayaran',
        'status',
    ];

    public function keranjang(){
        return $this->belongsTo(Keranjang::class, 'id');
    }

}
