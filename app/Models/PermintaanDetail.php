<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermintaanDetail extends Model
{
    use HasFactory;

    // Gunakan koneksi ke database warehouse
    protected $connection = 'warehouse';

    // Pastikan nama tabel sesuai
    protected $table = 'detail_permintaan';

    // Kolom yang bisa diisi
    protected $fillable = [
        'id_permintaan',
        'nomor_permintaan_barang',
        'kode_barang',
        'nama_barang',
        'jumlah',
        'satuan',
        'keterangan',
    ];

    // Relasi ke Permintaan utama
    public function permintaan()
    {
        return $this->belongsTo(Permintaan::class, 'id_permintaan');
    }
}
