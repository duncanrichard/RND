<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaan';

    protected $fillable = [
        'id',
        'nomor_permintaan_barang',
        'tanggal',
        'id_input',
        'nama_gudang',
        'jenis_permintaan',
        'nomor_surat_perintah_produksi',
        'tujuan_permintaan_barang',
    ];

    public function detailpermintaan()
    {
        return $this->hasMany(PermintaanDetail::class, 'id_permintaan');
    }
    public function gudang()
    {
        return $this->belongsTo(Warehouse::class, 'nama_gudang', 'warehouse');
    }
}
