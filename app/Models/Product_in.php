<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_in extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 'product_ins';

    // The attributes that are mass assignable
    protected $fillable = [
        'ProductCode',
        'DateTime',
        'Quantity',
        'UnitPrice',
        'TotalPrice',
    ];

    // Relationship to the Product model
    public function product()
    {
        return $this->belongsTo(Products::class, 'ProductCode', 'ProductCode');
    }

    protected $casts = [
        'DateTime' => 'datetime'
    ];
}
