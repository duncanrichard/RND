<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterFormulaSample extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_formula',
        'tanggal',
        'id_input',
        'kode_sample',
        'nama_sample',
        'bahan_aktif',
        'jumlah_total',
        'jumlah_hpp',
    ];

    public function details()
    {
        return $this->hasMany(MasterFormulaSampleDetail::class, 'formula_sample_id');
    }

    public function prosedurs()
    {
        return $this->hasMany(MasterFormulaSampleProsedurKerja::class, 'formula_sample_id');
    }

    public function spesifikasis()
    {
        return $this->hasMany(MasterFormulaSampleSpesifikasi::class, 'formula_sample_id');
    }

    public function spesifikasiTambahan()
{
    return $this->hasMany(SpesifikasiTambahan::class, 'formula_sample_id');
}

    
}
