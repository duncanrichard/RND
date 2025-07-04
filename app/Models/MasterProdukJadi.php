<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProdukJadi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori_produk_jadi',
        'kode_produk_jadi',
        'nama_merek',
        'nomor_merk', // Tambahan
        'masa_berlaku_merk', // Tambahan
        'nama_produk',
        'netto',
        'satuan',
        'expired_date_produk_jadi',
        'rekomendasi_penyimpanan',
        'nomor_notifikasi_bpom',
        'masa_berlaku_notifikasi_bpom',
        'nomor_haki',
        'masa_berlaku_haki',
        'nomor_sertifikat_halal',
        'masa_berlaku_sertifikat_halal',
        'kategori_kemasan',
        'jenis_kemasan',
        'harga_produk',

    ];

    protected $table = 'master_produk_jadis'; // Nama tabel di database
}
