<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBahanKemas extends Model
{
    use HasFactory;

    protected $table = 'stok_bahan_kemas';

    protected $fillable = [
        'id',
        'nomor_input_stok_bahan_kemas',
        'tanggal',
        'id_input',
        'jenis_penerimaan_bahan_kemas',
        'nomor_penerimaan_bahan_kemas',
        'nomor_penerimaan_bahan_kemas_customer',
        'gudang_penyimpanan'
    ];
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'gudang_penyimpanan', 'warehouse');
    }

    public function detailstokbahankemas()
    {
        return $this->hasMany(StokBahanKemasDetail::class,'id_stok_bahan_kemas');
    }
}
