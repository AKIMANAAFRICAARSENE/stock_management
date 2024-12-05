<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    protected $primaryKey = 'ProductCode';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'products';
    protected $fillable = ['ProductCode', 'ProductName'];
}
