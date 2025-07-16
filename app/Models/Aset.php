<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $connection = 'hris';

    protected $table = 'aset';

    protected $fillable = [
        'kode_aset',
        'nama_aset',
        'kategori_aset',
        'departemen',
        'lokasi_aset',
    ];

    public function kategoriAset()
    {
        return $this->hasOne(KategoriAset::class, 'kode_kategori_aset', 'kategori_aset');
    }
}
