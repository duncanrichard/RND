<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKategoriProduk extends Model
{
    use HasFactory;

    protected $table = 'master_kategori_produk';

    protected $fillable = [
        'kode',
        'nama_kategori',
    ];
}
