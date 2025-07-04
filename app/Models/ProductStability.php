<?php

// app/Models/ProductStability.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStability extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'parameter', 'type', 'syarat', 'checklist'];

    protected $casts = [
        'checklist' => 'array',
        'syarat' => 'json',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
