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
        $selectedProductIds = session('cart', []);


        return view('product.index', compact('inventories','selectedProductIds'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:inventories,id',
            'color' => 'required|string',
            'size' => 'required|string',
        ]);

        // Get the cart from the session or initialize it as an empty array
        $cart = session('cart', []);

        // Check if the product with the same characteristics is already in the cart
        foreach ($cart as $item) {
            if (
                $item['product_id'] == $request->product_id &&
                $item['color'] == $request->color &&
                $item['size'] == $request->size
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product with the same characteristics is already in the cart.'
                ]);
            }
        }

        // Add the product to the cart if it's not already there
        $cart[] = $request->only('product_id', 'color', 'size');
        session(['cart' => $cart]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to the cart.'
        ]);
    }


}
