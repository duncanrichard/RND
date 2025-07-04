<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaSampleSpesifikasi extends Model
{
    use HasFactory;

    protected $table = 'master_formula_samples_spesifikasi';

    protected $fillable = [
        'formula_sample_id',
        'bentuk',
        'warna',
        'bau',
        'ph',
        'viskositas',
        'dll',
    ];

    public function formula_sample()
    {
        return $this->belongsTo(MasterFormulaSample::class, 'formula_sample_id', 'id');
    }
}
