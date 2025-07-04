<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaProdukJadiBahanKemas extends Model
{
    use HasFactory;

    protected $table = 'master_formula_produk_jadi_bahan_kemas';

    protected $fillable = [
        'master_formula_produk_jadi_id',
        'bahan_kemas_id',
        'kode_kemasan',
        'nama_kemasan',
        'satuan',
        'jumlah',
        'hpp',
    ];

    public function formulaProdukJadi()
    {
        return $this->belongsTo(MasterFormulaProdukJadi::class, 'master_formula_produk_jadi_id', 'id');
    }
}
