<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterBahanBaku extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dengan konvensi plural
    protected $table = 'master_bahan_bakus';

    // Kolom yang dapat diisi melalui mass assignment
    protected $fillable = [
        'kode',
        'raw_material',
        'inci_name',
        'sediaan',
        'principle',
        'supplier',
        'function',
        'jumlah_diterima',
        'satuan', // Tambahkan kolom satuan
        'tgl_terima',
        'keterangan',
        'status_approval', // Tambahkan ini
    ];
    public function supplierData()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'id');
        
    }
    public function satuanData()
    {
        return $this->belongsTo(MasterSatuan::class, 'satuan', 'id');
    }
}
