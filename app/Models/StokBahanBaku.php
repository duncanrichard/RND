<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'stok_bahan_baku';

    protected $fillable = [
        'id',
        'nomor_input_stok_bahan_baku',
        'tanggal',
        'id_input',
        'nomor_penerimaan_bahan_baku',
        'gudang_penyimpanan',
    ];
    
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'gudang_penyimpanan', 'warehouse');
    }

    public function detailstokbahanbaku()
    {
        return $this->hasMany(StokBahanBakuDetail::class, 'id_stok_bahan_baku');
    }
}
