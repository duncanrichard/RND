<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterCPB extends Model
{
    use HasFactory;

    protected $table = 'master_cpbs'; // Pastikan sesuai dengan nama tabel di migrasi

    protected $fillable = [
        'nama_produk',
        'batch_size_berat',
        'batch_size_satuan',
        'kode_produk',
        'nomor_cpb',
        'file_dokumen',
    ];
}
