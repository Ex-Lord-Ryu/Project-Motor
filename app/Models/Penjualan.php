<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_pembeli',
        'alamat',
        'email',
        'no_telp',
        'tgl_jual',
        'nama_barang',
        'tipe_barang',
        'harga',
        'diskon',
        'quantity',
        'total_harga',
    ];
}
