<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPPN extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_p_p_n_s';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ppn',
        'pph',
        'kurs_usd',
        'kurs_euro', // Tambahkan kolom kurs_euro
        'kurs_yuan', // Tambahkan kolom kurs_yuan
        'kurs_rupiah', 
        'additional_cost',
    ];
}
