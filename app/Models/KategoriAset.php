<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriAset extends Model
{
    use HasFactory;

    protected $connection = 'hris';

    protected $table = 'kategori_aset';

    protected $fillable = [
        'kode_kategori_aset',
        'nama_kategori_aset',

    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'kode_kategori_aset', 'kategori_aset');
    }
}
