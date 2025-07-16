<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $connection = 'hris';

    protected $table = 'departemen';

    protected $fillable = [
        'kode_departemen.',
        'nama_departemen'
    ];

    public function RequestPerbaikan()
    {
        return $this->belongsTo(RequestPerbaikanTeknik::class, 'kode_departemen', 'departemen_pemohon');
    }
}
