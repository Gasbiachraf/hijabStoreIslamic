<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return new ProductCollection($products);
    }
    public function categories()
    {
        $categories = Category::pluck('name');
        return response()->json($categories);
    }
    public function colors()
    {
        $colors = Variant::distinct()->pluck('color');
        return response()->json($colors);
    }
}
