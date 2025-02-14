<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index() {
        $products = Product::all();
        return new ProductCollection($products);
    }
}
