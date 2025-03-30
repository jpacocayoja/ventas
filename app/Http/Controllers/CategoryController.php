<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function getall()
    {
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    public function store(Request $request)
    {
        $empData = [
            'name' => $request->name,
            'description' => $request->description,
        ];
        Category::create($empData);
        return response()->json([
            'status' => 200,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $category = Category::find($request->id);

        if(!$category){ //si hubo error
            return response()->json([
                'status' => 404,
                'message' => 'Category not found'
            ]);
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return response()->json([
            'status' => 200,
            'message' => 'Category updated successfully'
        ]);
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);

        if(!$category){ //hubo error
            return response()->json(['status' => 400, 'message' => 'Failed to delete employee.']);
        }

        $category->delete();
        return response()->json(['status' => 200, 'message' => 'Employee deleted successfully.']);
    }
}
