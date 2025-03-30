<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'purchase_price',
        'sale_price',
        'quantity',
        'category_id'
    ];

    
     public function category()
     {
         return $this->belongsTo(Category::class);
     }

      // Relación: Un producto puede estar en varias ventas
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_product')
                    ->withPivot('quantity', 'subtotal')
                    ->withTimestamps();
    }
}
