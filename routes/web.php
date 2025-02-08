<?php

use App\Http\Controllers\ArrivalproductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\CommandVariantController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VariantController;
use App\Models\CommandVariant;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //?Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/clients/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit');
    Route::put('/clients/update/{id}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/delete/{id}', [ClientController::class, 'destroy'])->name('clients.delete');
    //*Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    //!Commande
    Route::get('/cart', [CommandController::class, 'index'])->name('cart.index');
    Route::post('/cart/store', [ProductController::class, 'store'])->name('cart.store');
    Route::post('/checkout', [CommandController::class, 'store'])->name('checkout.store');
    Route::get('/commands', [CommandController::class, 'show'])->name('command.index');
    Route::get('/command-variants/{id}/edit', [CommandVariantController::class, 'edit'])->name('commandVariants.edit');
    Route::patch('/command-variants/{id}', [CommandVariantController::class, 'update'])->name('commandVariants.update');
    Route::get('/get-sizes/{variantId}', [CommandVariantController::class, 'getSizes']);
    Route::post('/cart/remove', [CommandController::class, 'removeFromCart'])->name('cart.remove');
    //?ArrivalProducts
    Route::get('/arrival', [ArrivalproductController::class, 'index'])->name('arrival.index');
    Route::get('/arrival/{id}/edit', [ArrivalProductController::class, 'edit'])->name('arrival.edit');
    Route::patch('/arrival/{id}', [ArrivalProductController::class, 'update'])->name('arrival.update');










    Route::delete('/delete/product/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::put('/update/product/{product}', [VariantController::class, 'update'])->name('product.update');
    Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
    Route::post('/add_product', [VariantController::class, 'store'])->name('product.store');
    Route::get('/addproduct', [VariantController::class, 'index'])->name('product.index');
    Route::delete('/delete/variant/{id}', [VariantController::class, 'destroy'])->name('variant.delete');
    Route::get('/restock/variant/{id}', [VariantController::class, 'show'])->name('variant.show');
    Route::patch('/restock/variant/{product}', [VariantController::class, 'restock'])->name('variant.restock');

    // images 
    Route::post('/upload/image', [ImageController::class, 'store'])->name('image.store');
    Route::delete('/delete/image/{id}', [ImageController::class, 'destroy'])->name('image.delete');
});

<<<<<<< HEAD
// ^^ Blogs :
Route::get('/blogs' , [BlogController::class , 'index']) ;
Route::post('blogs/store' , [BlogController::class , 'store'])->name('blog.store');
Route::put('blogs/update/{blog}' , [BlogController::class , 'update'])->name('blog.update');
Route::delete('blogs/delete/{blog}' , [BlogController::class , 'delete'])->name('blog.delete');

require __DIR__.'/auth.php';
=======
require __DIR__ . '/auth.php';
>>>>>>> 30d37ad37192fb505abe128fbf897232fd072283
