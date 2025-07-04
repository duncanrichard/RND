<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaSampleProsedurKerja extends Model
{
    use HasFactory;

    protected $table = 'master_formula_samples_prosedur_kerja';

    protected $fillable = [
        'formula_sample_id',
        'detail'
    ];

    public function formula_sample()
    {
        return $this->belongsTo(MasterFormulaSample::class, 'formula_sample_id', 'id');
    }
}
