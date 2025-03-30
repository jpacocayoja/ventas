<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        return view('product.index');
    }

    public function getall()
    {
        $products = Product::with('category')->get();
        return response()->json([
            'status' => 200,
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'purchase_price' => $product->purchase_price,
                    'sale_price' => $product->sale_price,
                    'quantity' => $product->quantity,
                    'category_id' => $product->category ? $product->category->id : null,
                    'category_name' => $product->category ? $product->category->name : 'No Category',
                ];
            })
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0.01',
            'sale_price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $productData = [
            'name' => $request->name,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'category_id' => $request->category_id,
        ];

        Product::create($productData);

        return response()->json([
            'status' => 200,
            'message' => 'Product created successfully',
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0.01',
            'sale_price' => 'required|numeric|min:0.01',
            'quantity' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found',
            ]);
        }

        $product->name = $request->name;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product updated successfully',
        ]);
    }

    public function delete(Request $request)
    {
        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'status' => 400,
                'message' => 'Failed to delete product.',
            ]);
        }

        $product->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Product deleted successfully',
        ]);
    }
}
