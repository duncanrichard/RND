<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_bakus';

    protected $fillable = [
        'kode_bahan_baku',
        'urutan_kode_bahan_baku',
        'koding_bahan_baku',
        'nama_bahan_baku',
        'nama_coding',
        'nama_inci',
        'jenis_sediaan',
        'satuan',
        'cara_penyimpanan',
        'harga_po',
        'ppn',
        'mark_up',
        'hpbb',
        'coa_file', // File CoA
        'msds_file', // File MSDS
        'sertifikat_halal_file', // File Sertifikat Halal
    ];
    

    public function satuan()
    {
        return $this->belongsTo(MasterSatuan::class, 'satuan', 'id');
    }

    public function jenisBahanBaku()
    {
        return $this->belongsTo(JenisBahanBaku::class, 'kode_bahan_baku', 'id');
    }
    public function jenisBahan()
{
    return $this->belongsTo(JenisBahanBaku::class, 'jenis_bahan_baku_id', 'id');
}

}
