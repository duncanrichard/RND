<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    // ✅ Tambahkan koneksi ke database warehouse
    protected $connection = 'warehouse';

    protected $table = 'warehouse'; // pastikan sesuai nama tabel di DB

    protected $fillable = [
        'kode_warehouse',
        'warehouse'
    ];
}
