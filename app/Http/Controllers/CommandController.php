<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Command;
use App\Models\CommandVariant;
use App\Models\Product;
use App\Models\Size;
use App\Models\Variant;
use DB;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    //
// CartController.php


    public function index()
    {

        $clients = Client::all();
        $selectedProductIds = session('cart', []);

        // Fetch products with only the selected color and size
        $selectedProducts = collect($selectedProductIds)->map(function ($item) {
            return Product::where('id', $item['product_id'])
                ->whereHas('inventories.variants', function ($query) use ($item) {
                    $query->where('color', $item['color'])
                        ->whereHas('sizes', function ($sizeQuery) use ($item) {
                            $sizeQuery->where('size', $item['size']);
                        });
                })
                ->with([
                    'inventories.variants.sizes' => function ($query) use ($item) {
                        $query->where('size', $item['size']);
                    },
                    'inventories.variants' => function ($query) use ($item) {
                        $query->where('color', $item['color']);
                    },
                ])
                ->first();
        })->filter(); // Remove null results if any

        return view('cart.cart', compact('selectedProducts', 'clients'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'new_client_name' => 'nullable|required_without:client_id|string|max:255',
            'new_client_phone' => 'nullable|required_without:client_id|string|max:15',
            'new_client_address' => 'nullable|string|max:255',
            'status' => 'required|in:sell,rent',
            'livraison' => 'required|in:not_delevred,pending,delevred',

        ]);

        DB::transaction(function () use ($request) {
            // Add client if new
            $clientId = $request->client_id;
            if (!$clientId) {
                $client = Client::create([
                    'name' => $request->new_client_name,
                    'GSM' => $request->new_client_phone,
                    'adress' => $request->new_client_address,
                ]);
                $clientId = $client->id;
            }

            // Create command
            foreach ($request->products as $productId => $productData) {
                $command = Command::create([
                    'client_id' => $clientId,
                    'status' => $request->status,
                    'livraison' => $request->livraison,
                ]);
                // Add products to command_variants
                CommandVariant::create([
                    'command_id' => $command->id,
                    'variant_id' => $productData['variant_id'], // Ensure this is the actual ID
                    'quantity' => $productData['quantity'],
                    'salePrice' => $productData['sale_price'],
                ]);
                // Update the inventory for the size
                $size = Size::where('variant_id', $productData['variant_id'])
                    ->where('size', $productData['size'])
                    ->firstOrFail();

                if ($size->quantity < $productData['quantity']) {
                    throw new \Exception("Not enough stock for size: {$productData['size']} of variant ID: {$productData['variant_id']}");
                }

                // Subtract the purchased quantity from the stock
                $size->update([
                    'quantity' => $size->quantity - $productData['quantity'],
                ]);
            }

        });
        session()->forget('cart');

        return redirect()->route('products.index')->with('success', 'Checkout completed successfully!');
    }


}
