<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBahanKemasDetail extends Model
{
    use HasFactory;

    // ✅ Tambahkan koneksi ke database warehouse
    protected $connection = 'warehouse';

    protected $table = 'detail_stok_bahan_kemas';

    protected $fillable = [
        'id_stok_bahan_kemas',
        'nomor_input_stok_bahan_kemas',
        'tanggal_datang',
        'kode_bahan_kemas',
        'nama_bahan_kemas',
        'nomor_analisa',
        'jumlah_stok_masuk',
        'satuan',
    ];

    public function stokbahankemas()
    {
        return $this->belongsTo(StokBahanKemas::class, 'id_stok_bahan_kemas');
    }
}
