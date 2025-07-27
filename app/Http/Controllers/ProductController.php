<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    //
    public function index()
    {
        try {
            $inventories = Inventory::all();
            $selectedProductIds = session('cart', []);

            return view('product.index', compact('inventories', 'selectedProductIds'));
        } catch (\Exception $e) {
            Log::error('ProductController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading products. Please try again.');
        }
    }
    public function store(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('ProductController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding product to cart. Please try again.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('ProductController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while deleting the product. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }
            $categories = Category::all();
            $subCategories = Subcategory::all();
            return view('product.update_product', compact('product', 'categories', 'subCategories'));
        } catch (\Exception $e) {
            Log::error('ProductController show error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the product. Please try again.');
        }
    }
}
