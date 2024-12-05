<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_out extends Model
{
    use HasFactory;

    protected $table = 'product_outs';

    protected $fillable = [
        'ProductCode',
        'DateTime',
        'Quantity',
        'UnitPrice',
        'TotalPrice',
    ];

    protected $casts = [
        'DateTime' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'ProductCode', 'ProductCode');
    }
}
