<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHargaPO extends Model
{
    use HasFactory;

    protected $table = 'master_harga_po';

    protected $fillable = [
        'harga',
    ];
}
