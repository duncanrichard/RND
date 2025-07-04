<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianDetail extends Model
{
    use HasFactory;

    protected $connection = 'warehouse';
    protected $table = 'detail_pengembalian';

    protected $fillable = [
        'id',
        'id_pengembalian',
        'nomor_pengembalian_barang',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'keterangan',
    ];
    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'id_pengambalian');
    }
}
