<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBahanBakuDetail extends Model
{
    use HasFactory;

    // ✅ Tambahkan koneksi ke database warehouse
    protected $connection = 'warehouse';

    protected $table = 'detail_stok_bahan_baku';

    protected $fillable = [
        'id_stok_bahan_baku',
        'nomor_input_stok_bahan_baku',
        'tanggal_datang',
        'kode_bahan_baku',
        'nama_bahan_baku',
        'principle',
        'nomor_batch',
        'expired_date',
        'nomor_analisa',
        'nama_supplier',
        'jumlah_stok_masuk',
        'satuan',
    ];

    public function stokbahanbaku()
    {
        return $this->belongsTo(StokBahanBaku::class, 'id_stok_bahan_baku');
    }
}
