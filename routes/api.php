<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\productController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/categories', [productController::class, 'categories']);
Route::get('/products', [productController::class, 'index']);
Route::get('/colors', [productController::class, 'colors']);
//Contact 
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/blogs', [BlogController::class, 'index']);
