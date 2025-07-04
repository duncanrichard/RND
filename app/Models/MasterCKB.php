<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCKB extends Model
{
    use HasFactory;

    protected $table = 'master_ckbs';

    protected $fillable = [
        'nama_produk',
        'batch_size_berat',
        'batch_size_satuan',
        'kode_produk',
        'nomor_cpb',
        'file_dokumen',
    ];
}
