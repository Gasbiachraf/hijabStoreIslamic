<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    Route::post('/cart/store', [CommandController::class, 'store'])->name('cart.store');






    Route::post('/add_product', [VariantController::class,'store'])->name('product.store');
    Route::get('/addproduct', [VariantController::class,'index'])->name('product.index');
});

require __DIR__.'/auth.php';
