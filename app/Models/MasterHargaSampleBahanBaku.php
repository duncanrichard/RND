<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHargaSampleBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'master_harga_sample_bahan_bakus';

    protected $fillable = [
        'kode_bahan_baku',
        'nama_bahan_baku',
        'principle',
        'supplier',
        'harga_usd',
        'harga_idr',
        'ppn',
        'pph',
        'harga_total',
        'qty',
        'kategori_satuan',
        'moq',
        'additional_cost',
        'harga_akhir',
    ];
    

    // Relasi ke MasterSatuan
    public function bahanBaku()
    {
        return $this->belongsTo(MasterBahanBaku::class, 'kode_bahan_baku', 'kode'); // Pastikan field relasi benar
    }

    public function satuan()
    {
        return $this->belongsTo(MasterSatuan::class, 'kategori_satuan', 'id'); // Pastikan field relasi benar
    }

    public function supplierData()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'id');
    }
}
