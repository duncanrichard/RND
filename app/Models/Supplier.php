<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $connection = 'purchasing'; // Gunakan koneksi ke database 'purchasing'
    protected $table = 'suppliers'; // Nama tabel
    protected $fillable = ['nama_suplier']; // Field yang bisa diisi
}
