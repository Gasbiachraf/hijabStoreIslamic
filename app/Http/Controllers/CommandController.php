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
use Illuminate\Support\Facades\Log;

class CommandController extends Controller
{
    //
// CartController.php


    public function index()
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('CommandController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the cart. Please try again.');
        }
    }
    public function show()
    {
        try {
            $commands = Command::all();
            $commandVariants = CommandVariant::all();
            // dd($commandVariants);
            return view('command.index', compact('commands', 'commandVariants'));
        } catch (\Exception $e) {
            Log::error('CommandController show error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading commands. Please try again.');
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());

            $validated = $request->validate([
                'client_id' => 'nullable|exists:clients,id',
                'new_client_name' => 'nullable',
                'new_client_phone' => 'nullable',
                'new_client_address' => 'nullable',
                'status' => 'required|in:sell,rent',
                'livraison' => 'required|in:in_present,livraison',
            ]);

            DB::transaction(function () use ($request) {
                $clientId = $request->client_id;
                if (!$clientId) {
                    $client = Client::create([
                        'name' => $request->new_client_name,
                        'GSM' => $request->new_client_phone,
                        'adress' => $request->new_client_address,
                    ]);
                    $clientId = $client->id;
                }
                //? making the command iserting of the loop !!!!!!!!
                $command = Command::create([
                    'client_id' => $clientId,
                    'status' => $request->status,
                    'livraison' => $request->livraison,
                ]);
                foreach ($request->products as $productId => $productData) {
                    CommandVariant::create([
                        'command_id' => $command->id,
                        'variant_id' => $productData['variant_id'],
                        'size' => $productData['size'],
                        'quantity' => $productData['quantity'],
                        'salePrice' => $productData['sale_price'],
                    ]);
                    $size = Size::where('variant_id', $productData['variant_id'])
                        ->where('size', $productData['size'])
                        ->firstOrFail();

                    if ($size->quantity < $productData['quantity']) {
                        throw new \Exception("Not enough stock for size: {$productData['size']} of variant ID: {$productData['variant_id']}");
                    }

                    $size->update([
                        'quantity' => $size->quantity - $productData['quantity'],
                    ]);
                }
            });

            session()->forget('cart');

            return redirect()->route('products.index')->with('success', 'Checkout completed successfully!');
        } catch (\Exception $e) {
            Log::error('CommandController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred during checkout. Please try again.');
        }
    }

    public function removeFromCart(Request $request)
    {
        try {
            $cart = session('cart', []);
            // dump($cart);
            // dd($request->all())
            // Remove item based on `product_id`, `color`, and `size`
            foreach ($cart as $key => $item) {
                if (
                    $item['product_id'] == $request->product_id &&
                    $item['color'] == $request->color &&
                    $item['size'] == $request->size
                ) {
                    unset($cart[$key]);
                    break;
                }
            }

            // Re-index array and save it back to the session
            session(['cart' => array_values($cart)]);

            return redirect()->back()->with('success', 'Item removed from cart successfully.');
        } catch (\Exception $e) {
            Log::error('CommandController removeFromCart error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while removing item from cart. Please try again.');
        }
    }








}
