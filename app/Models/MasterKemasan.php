<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKemasan extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model
    protected $table = 'master_kemasan';

    // Tentukan kolom yang dapat diisi (fillable)
    protected $fillable = [
        'kategori_kemasan',
        'jenis_kemasan',
        'kode_kemasan',
        'nama_kemasan',
        'satuan',
        'cara_penyimpanan',
        'harga_po',
        'ppn',
        'mark_up',
        'hpbk',
    ];
    

   // Model MasterKemasan.php
public function jenisKemasan()
{
    return $this->belongsTo(KodeBahanKemas::class, 'jenis_kemasan', 'id');
}

public function kodeBahanKemas()
{
    return $this->belongsTo(KodeBahanKemas::class, 'jenis_kemasan', 'id');
}

public function satuan()
{
    return $this->belongsTo(MasterSatuan::class, 'satuan', 'id');
}

}
