<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBahanKemas extends Model
{
    use HasFactory;

    protected $table = 'kode_bahan_kemas';

    protected $fillable = [
        'kode',
        'nama_kode',
        'jenis_kemasan',
    ];
    public function masterKemasan()
{
    return $this->hasMany(MasterKemasan::class, 'jenis_kemasan', 'id');
}

}
