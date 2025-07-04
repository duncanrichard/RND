<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaSampleDetail extends Model
{
    use HasFactory;

    protected $table = 'master_formula_samples_details';

    protected $fillable = [
        'formula_sample_id',
        'premix',
        'kode_bahan_baku',
        'nama_bahan_baku', // Baru
        'inci_name',       // Baru
        'function',        // Baru
        'supplier',        // Baru
        'satuan',          // Baru
        'jumlah_satuan',
        'hpp',
    ];

    public function formula_sample()
    {
        return $this->belongsTo(MasterFormulaSample::class, 'formula_sample_id', 'id');
    }
    public function satuanModel()
    {
        return $this->belongsTo(MasterSatuan::class, 'satuan', 'id');
    }
}
