<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama_kategori',
        'gambar',
        'keterangan',
    ];

    public function paket_pembelian()
    {
        return $this->hasMany(Paket_pembelian::class, 'kategori_id');
    }
}
