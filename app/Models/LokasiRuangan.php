<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiRuangan extends Model
{
    use HasFactory;

    protected $connection = 'hris';

    protected $table = 'ruangan';

    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
    ];

    public function RequestPerbaikan()
    {
        return $this->belongsTo(RequestPerbaikanTeknik::class, 'kode_ruangan', 'lokasi_ruangan');
    }
}
