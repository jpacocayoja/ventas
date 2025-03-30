<?php
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/category', [CategoryController::class, 'index'])->name('indexCategory');
Route::get('/category/getall', [CategoryController::class, 'getall'])->name('getallCategory');
Route::post('/category/store', [CategoryController::class, 'store'])->name('storeCategory');
Route::post('/category/update', [CategoryController::class, 'update'])->name('updateCategory');
Route::delete('/category/delete', [CategoryController::class, 'delete'])->name('deleteCategory');


Route::get('/product', [ProductController::class, 'index'])->name('indexProduct');
Route::get('/product/getall', [ProductController::class, 'getall'])->name('getallProduct');
Route::post('/product/store', [ProductController::class, 'store'])->name('storeProduct');
Route::post('/product/update', [ProductController::class, 'update'])->name('updateProduct');
Route::delete('/product/delete', [ProductController::class, 'delete'])->name('deleteProduct');


Route::get('/sales', [SaleController::class, 'index'])->name('indexSale');
Route::get('/sales/all', [SaleController::class, 'getAllSales'])->name('getallSales');
Route::post('/sales/store', [SaleController::class, 'store'])->name('storeSale');
Route::delete('/sales/delete', [SaleController::class, 'destroy'])->name('deleteSale');
Route::get('/sale/details', [SaleController::class, 'getDetails'])->name('getSaleDetails');
