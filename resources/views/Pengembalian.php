<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'id',
        'nomor_pengembalian_barang',
        'tanggal',
        'id_input',
        'nama_gudang',
        'jenis_pengembalian',
        'nomor_surat_perintah_produksi',
        'tujuan_pengembalian_barang',
    ];

    public function detailpengembalian()
    {
        return $this->hasMany(PengembalianDetail::class, 'id_pengembalian');
    }
    
    public function gudang()
    {
        return $this->belongsTo(Warehouse::class, 'nama_gudang', 'warehouse');
    }

}
