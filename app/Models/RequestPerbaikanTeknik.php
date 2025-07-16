<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPerbaikanTeknik extends Model
{
    use HasFactory;

    protected $connection = 'mysql_engineering';

    protected $table = 'request_perbaikan_teknik';

    protected $fillable = [
        'nomor_request_perbaikan',
        'jenis',
        'jenis_perbaikan',
        'periode',
        'tanggal',
        'id_input',
        'departemen_pemohon',
        'lokasi_ruangan',
    ];

    public function Detail()
    {
        return $this->hasMany(RequestPerbaikanTeknikDetail::class, 'request_perbaikan_id', 'id');
    }
}
