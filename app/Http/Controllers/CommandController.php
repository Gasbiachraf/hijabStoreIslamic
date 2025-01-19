<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    //
// CartController.php

public function store(Request $request)
{
    $selectedProducts = $request->input('products', []);
    
    // dd($selectedProducts);
    // Add the selected products to the session cart
    foreach ($selectedProducts as $product) {
        $product = json_decode($product, true);
        $cart = session()->get('cart', []);


        session()->put('cart', $cart);
    }

    return redirect()->route('cart.index');
}

public function index()
    {
        // Retrieve the cart from the session
        $cart = session()->get('cart', []);

        // Get detailed product and variant information
        foreach ($cart as &$item) {
            $product = Product::find($item['product_id']);
            // $variant = Variant::find($item['variant_id']);
            
            // Add product and variant details to the cart item
            $item['product'] = $product;
            // $item['variant'] = $variant;
        }

        return view('cart.cart', compact('cart'));
    }



}
