<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sale_date', 'total'];

    // Relación: Una venta tiene muchos productos a través de la tabla pivote sale_product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')
                    ->withPivot('quantity', 'subtotal')
                    ->withTimestamps();
    }
}
