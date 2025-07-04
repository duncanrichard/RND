<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PurchaseRequest extends Model
{
    use HasFactory;

    protected $connection = 'purchasing'; // <--- Tambahkan ini

    protected $fillable = [
        'no_purchase_request',
        'tanggal',
        'id_input',
        'departemen',
        'kategori_barang'
    ];

    public function details()
    {
        return $this->hasMany(PurchaseRequestDetail::class);
    }
}

