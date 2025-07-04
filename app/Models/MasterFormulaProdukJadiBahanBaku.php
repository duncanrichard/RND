<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaProdukJadiBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'master_formula_produk_jadi_bahan_baku';

    protected $fillable = [
        'master_formula_produk_jadi_id',
        'bahan_baku_id',
        'kode_bahan_baku', // Tambahkan ini
        'nama_coding',
        'satuan',
        'jumlah',
        'hpp'
    ];

    public function formulaProdukJadi()
    {
        return $this->belongsTo(MasterFormulaProdukJadi::class, 'master_formula_produk_jadi_id', 'id');
    }
}
