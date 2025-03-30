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

    public function index()
    {
        return view('sale.index');
    }


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

            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['id']);

                if ($product->quantity < $productData['quantity']) {
                    return response()->json([
                        'status' => 400,
                        'message' => "Not enough stock for product: {$product->name} (Available: {$product->quantity}, Requested: {$productData['quantity']})"
                    ]);
                }
            }

            $currentDate = Carbon::today();
            $sale = Sale::create([
                'sale_date' => $currentDate,
                'total' => $request->total,
            ]);


            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['id']);


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

    public function getDetails(Request $request)
    {
        // Cargar la venta con todos los productos asociados
        $sale = Sale::with(['saleProducts.product'])->find($request->id);

        if (!$sale) {
            return response()->json(['status' => 404, 'message' => 'Sale not found']);
        }

        // Devolver los detalles de la venta
        return response()->json([
            'status' => 200,
            'sale' => [
                'id' => $sale->id,
                'sale_date' => $sale->sale_date,
                'total' => (float)$sale->total,
                'products' => $sale->saleProducts->map(function ($saleProduct) {
                    return [
                        'id' => $saleProduct->product->id,
                        'name' => $saleProduct->product->name,
                        'quantity' => $saleProduct->quantity,
                        'subtotal' => (float)$saleProduct->subtotal,
                    ];
                }),
            ],
        ]);
    }



    public function destroy(Request $request)
    {
        $sale = Sale::find($request->id);
        if (!$sale) {
            return response()->json(['status' => 404, 'message' => 'Sale not found']);
        }


        foreach ($sale->products as $product) {
            $product->increment('quantity', $product->pivot->quantity);
        }

        $sale->delete();
        return response()->json(['status' => 200, 'message' => 'Sale deleted successfully']);
    }
}
