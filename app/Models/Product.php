<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_produk',
        'tanggal',
        'id_input',
        'tgl_trial',
        'no_formula',
        'kode_sample'
    ];

    public function stabilities()
    {
        return $this->hasMany(ProductStability::class);
    }
}
