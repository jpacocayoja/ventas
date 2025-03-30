<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleProduct extends Model
{
    use HasFactory;

    // Definir la tabla si no sigue la convención de nombres
    protected $table = 'sale_product';

    // Asegúrate de que el modelo no asigne automáticamente los campos 'id', 'created_at' y 'updated_at'
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'subtotal',
    ];

    /**
     * Relación con el modelo Sale
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Relación con el modelo Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
