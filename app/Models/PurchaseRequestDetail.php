<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
    use HasFactory;

    protected $connection = 'purchasing'; // <--- Tambahkan ini juga

    protected $fillable = [
        'purchase_request_id',
        'kode_barang',
        'nama_barang',
        'kategori',
        'jumlah',
        'satuan',
        'rencana_kedatangan',
        'keterangan',
        'dokumen'
    ];

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
}

