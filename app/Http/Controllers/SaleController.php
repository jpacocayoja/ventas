<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\SaleProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class SaleController extends Controller
{
    // Mostrar la vista de ventas
    public function index()
    {
        return view('sale.index');
    }

    // Obtener todas las ventas en formato JSON
    public function getAllSales()
    {
        $sales = Sale::orderBy('sale_date', 'desc')->get();
        return response()->json(['status' => 200, 'sales' => $sales]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'total' => 'required|numeric',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.subtotal' => 'required|numeric',
            ]);
            
            $currentDate = Carbon::today();
            $sale = Sale::create([
                'sale_date' => $currentDate,
                'total' => $request->total,
            ]);
    
            // Guardar los productos vendidos
            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['id']);
    
                // Registrar los detalles de la venta (productos)
                SaleProduct::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'subtotal' => $productData['subtotal'],
                ]);
    
                // Actualizar el stock del producto
                $product->decrement('quantity', $productData['quantity']);
            }
    
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Sale completed successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }

    // Eliminar una venta
    public function destroy(Request $request)
    {
        $sale = Sale::find($request->id);
        if (!$sale) {
            return response()->json(['status' => 404, 'message' => 'Sale not found']);
        }

        // Restaurar el stock de los productos antes de eliminar la venta
        foreach ($sale->products as $product) {
            $product->increment('quantity', $product->pivot->quantity);
        }

        $sale->delete();
        return response()->json(['status' => 200, 'message' => 'Sale deleted successfully']);
    }
}
