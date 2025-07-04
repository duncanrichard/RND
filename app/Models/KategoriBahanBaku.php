<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'kategori_bahan_baku';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
    ];
}
