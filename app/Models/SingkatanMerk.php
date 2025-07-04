<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SingkatanMerk extends Model
{
    use HasFactory;

    protected $table = 'singkatan_merk';

    protected $fillable = [
        'nama_merk',
        'singkatan_merk',
        'tahun',
        'lokasi',
    ];
}
