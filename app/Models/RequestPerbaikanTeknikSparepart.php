<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPerbaikanTeknikSparepart extends Model
{
    use HasFactory;

    protected $connection = 'engineering';

    protected $table = 'request_perbaikan_teknik_kebutuhan_sparepart';

    protected $fillable = [
        'request_perbaikan_tindakan_id',
        'sparepart_id',
        'jumlah_terpakai',
        'keterangan',
    ];

    public function Tindakan()
    {
        return $this->belongsTo(RequestPerbaikanTeknikTindakan::class, 'request_perbaikan_tindakan_id', 'id');
    }

    public function masterSparepart()
    {
        return $this->hasOne(MasterSparepart::class, 'id', 'sparepart_id');
    }
}
