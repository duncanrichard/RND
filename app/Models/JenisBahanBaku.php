<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'jenis_bahan_baku'; // Update to your actual table name

    protected $fillable = [
        'jenis_bahan_baku',
        'nama_bahan_baku',
    ];
   
    public function bahanBaku()
    {
        return $this->hasMany(BahanBaku::class, 'jenis_bahan_baku_id', 'id');
    }
    
}
