<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_permintaan';

    protected $fillable = [
        'id',
        'id_permintaan',
        'nomor_permintaan_barang',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'keterangan',
    ];
    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'id_permintaan');
    }
}
