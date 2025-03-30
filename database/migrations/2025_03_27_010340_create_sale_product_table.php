<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sale_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');     // Si se elimina la venta, se eliminan las relaciones
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Si se elimina el producto, se eliminan las relaciones
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_product');
    }
};
