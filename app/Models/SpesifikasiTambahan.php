<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpesifikasiTambahan extends Model
{
    use HasFactory;

    protected $table = 'spesifikasi_tambahan';

    protected $fillable = [
        'formula_sample_id',
        'data_spesifikasi',
        'hasil',
    ];

    // Relasi ke MasterFormulaSample
    public function masterFormulaSample()
    {
        return $this->belongsTo(MasterFormulaSample::class, 'formula_sample_id');
    }
}
