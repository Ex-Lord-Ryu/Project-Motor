<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_supplier',
        'alamat',
        'email',
        'no_telp',
        'tgl_beli',
        'nama_barang',
        'tipe_barang',
        'harga',
        'diskon',
        'quantity',
        'total_harga',
    ];
}
