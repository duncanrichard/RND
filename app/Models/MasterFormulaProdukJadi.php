<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaProdukJadi extends Model
{
    use HasFactory;

    protected $table = 'master_formula_produk_jadi';

    protected $fillable = [
        'nomor_formula',
        'tanggal',
        'kode_produk_id',
        'id_input',
        'kode_produk',
        'nama_merek',
        'kategori',
        'nama_produk',
        'netto',
        'batch_size_berat',
        'satuan_berat',
        'batch_size_satuan',
        'jenis_satuan',
        'total_jumlah_bahan_baku',
        'total_hpp_bahan_baku',
        'total_jumlah_bahan_kemas',
        'total_hpp_bahan_kemas',
    ];

    public function bahanBaku()
    {
        return $this->hasMany(MasterFormulaProdukJadiBahanBaku::class, 'master_formula_produk_jadi_id');
    }

    public function bahanKemas()
    {
        return $this->hasMany(MasterFormulaProdukJadiBahanKemas::class, 'master_formula_produk_jadi_id');
    }
}
