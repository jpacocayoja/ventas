<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['sale_date', 'total'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_product')
            ->withPivot('quantity', 'subtotal')
            ->withTimestamps();
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class);
    }
}
