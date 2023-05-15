<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('categories', CategoryController::class)->except('destroy');
    Route::post('delete-category', [CategoryController::class,'destroy']);

    Route::resource('products', ProductController::class)->except('destroy');
    Route::post('delete-product', [ProductController::class,'destroy']);
    Route::post('delete-product-image', [ProductController::class,'productImage'])->name('products.image');
    Route::post('product-image/{id}', [ProductController::class,'uploadImage'])->name('products.uploadimage');
});
