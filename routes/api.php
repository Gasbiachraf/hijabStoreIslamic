<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\productController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [productController::class, 'index']);
Route::get('/blogs', [BlogController::class, 'index']);
