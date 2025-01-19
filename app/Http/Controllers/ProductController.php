<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {
        $inventories = Inventory::all();
        

        return view('product.index', compact('inventories'));
    }
    
}
