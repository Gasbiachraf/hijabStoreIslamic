<?php

namespace App\Http\Controllers;

use App\Models\arrivalproduct;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VariantController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        $subCategories = Subcategory::all();
        return view('product.add_product', compact('products', 'categories', 'subCategories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'array|min:3',
            'product_name.en' => 'required',
            'product_name.fr' => 'required',
            'product_name.ar' => 'required',
            'product_description' => 'array|min:3',
            'product_description.en' => 'required',
            'product_description.fr' => 'required',
            'product_description.ar' => 'required',
            'inventory_type' => 'array|min:3',
            'inventory_type.en' => 'required',
            'inventory_type.fr' => 'required',
            'inventory_type.ar' => 'required',
            'variant_images.*' => 'required',
            'prePrice' => 'required',
            'postPrice' => 'required',
            'ex_price' => 'required|nullable',
            'category_name' => 'nullable',
            'category_id' => 'nullable',
            'sub_category' => 'nullable',
            'sub_category_id' => 'nullable',
            'size' => 'array',
            'color' => 'array',
            'quantity' => 'array'
        ]);
        $category = null;
        $subCategory = null;

        if (!$request->category_id) {
            $category = Category::create([
                'name' => $request->category_name,
            ]);
        }
        if (!$request->sub_category_id) {
            $subCategory = Subcategory::create([
                'name' => $request->sub_category,
                'category_id' => $category === null ? $request->category_id : $category->id,
            ]);
        }

        $product = Product::create([
            'name' => $request->input('product_name'),
            'subcategory_id' => $subCategory !== null ? $subCategory->id : $request->sub_category_id,
            'description' => $request->input('product_description')
        ]);
        $inventory = Inventory::create([
            'product_id' => $product->id,
            'prePrice' => $request->prePrice,
            'postPrice' => $request->postPrice,
            'exPrice' => $request->ex_price,
            'type' => $request->input('inventory_type')
        ]);
        $colors = $request->input("color");
        $sizes = $request->input("size");
        $quantities = $request->quantity;
        $images = $request->file('variant_images');
        foreach ($colors as $key => $color) {
            $variant = Variant::create([
                'inventory_id' => $inventory->id,
                'color' => $color,
            ]);
            if ($images) {
                foreach ($images[$color] as $key => $img) {
                    $imageName = time() . '_' . $img->getClientOriginalName();
                    $variant->images()->create([
                        'path' => $imageName
                    ]);
                    $img->storeAs('images', $imageName, 'public');
                }
            }
            foreach ($sizes as $sizeKey => $size) {
                if (preg_match('/#([a-fA-F0-9]{6})_(\d+)/', $sizeKey, $matches)) {
                    $hex = $matches[1];
                    if ($color === "#" . $hex) {
                        $size = Size::create([
                            'variant_id' => $variant->id,
                            'size' => $size,
                            'quantity' => $quantities[$sizeKey]
                        ]);
                        arrivalproduct::create([
                            'arrivalDate' => $size->created_at,
                            'size_id' => $size->id,
                            'quantity' => $quantities[$sizeKey]
                        ]);
                    }
                }
            }
        }
        return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = Product::find($id);
        return view('product.restock_product', compact('product'));
    }

    public function update(Request  $request, Product $product)
    {
        $request->validate([
            'product_name' => 'array|min:3',
            'product_name.en' => 'required',
            'product_name.fr' => 'required',
            'product_name.ar' => 'required',
            'product_description' => 'array|min:3',
            'product_description.en' => 'required',
            'product_description.fr' => 'required',
            'product_description.ar' => 'required',
            'inventory_type' => 'array|min:3',
            'inventory_type.en' => 'required',
            'inventory_type.fr' => 'required',
            'inventory_type.ar' => 'required',
            'variant_images.*' => 'required',
            'prePrice' => 'required',
            'postPrice' => 'required',
            'ex_price' => 'required|nullable',
            'category_name' => 'nullable',
            'category_id' => 'nullable',
            'sub_category' => 'nullable',
            'sub_category_id' => 'nullable',
            'size' => 'array',
            'color' => 'array',
            'quantity' => 'array'
        ]);
        // dd('update');
        $category = null;
        $subCategory = null;

        if (!$request->category_id) {
            $category = Category::create([
                'name' => $request->category_name,
            ]);
        }
        if (!$request->sub_category_id) {
            $subCategory = Subcategory::create([
                'name' => $request->sub_category,
                'category_id' => $category === null ? $request->category_id : $category->id,
            ]);
        }
        $product->update([
            'name' => $request->input('product_name'),
            'subcategory_id' => $subCategory !== null ? $subCategory->id : $request->sub_category_id,
            'description' => $request->input('product_description')
        ]);

        $colors = $request->input("color");
        $sizes = $request->input("size");
        $quantities = $request->quantity;
        $images = $request->file('variant_images');
        // dd($product);
        // dd($colors);
        // $inventories = Inventory::where('product_id', $product->id)->get();
        // dd($inventories);
        foreach ($product->inventories as $inventory) {
            $inventory->update([
                'product_id' => $product->id,
                'prePrice' => $request->prePrice,
                'postPrice' => $request->postPrice,
                'exPrice' => $request->ex_price,
                'type' => $request->input('inventory_type')
            ]);
            if ($colors) {
                foreach ($colors as $key => $color) {
                    $variant = Variant::create([
                        'inventory_id' => $inventory->id,
                        'color' => $color,
                    ]);
                    if ($images) {
                        foreach ($images[$color] as $key => $img) {
                            $imageName = time() . '_' . $img->getClientOriginalName();
                            $variant->images()->create([
                                'path' => $imageName
                            ]);
                            $img->storeAs('images', $imageName, 'public');
                        }
                    }
                    foreach ($sizes as $sizeKey => $size) {
                        if (preg_match('/#([a-fA-F0-9]{6})_(\d+)/', $sizeKey, $matches)) {
                            $hex = $matches[1];
                            if ($color === "#" . $hex) {
                                Size::create([
                                    'variant_id' => $variant->id,
                                    'size' => $size,
                                    'quantity' => $quantities[$sizeKey]
                                ]);
                            }
                        }
                    }
                }
            }
        }
        return redirect()->route('products.index');
    }

    public function restock(Request $request, Product $product)
    {
        // $colors = [];
        // dd($request);
        foreach ($product->inventories as $key => $inventory) {
            foreach ($inventory->variants as $ke => $variant) {
                $col = $variant->color;
                foreach ($request->$col as $k => $element) {
                    $addedQt = Size::where('size', $k)->first();
                    $addedQt->update([
                        'quantity' => $element + $addedQt->quantity
                    ]);
                    arrivalproduct::create([
                        'arrivalDate' => $addedQt->updated_at,
                        'size_id' => $addedQt->id,
                        'quantity' => $element
                    ]);
                }
            }
        }
        return back();
    }
    public function destroy($id)
    {
        $variant = Variant::find($id);
        $variant->delete();
        return response()->json(200);
    }
}
