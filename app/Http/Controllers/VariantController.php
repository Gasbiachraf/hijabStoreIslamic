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
use Illuminate\Support\Facades\Log;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class VariantController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            $categories = Category::all();
            $subCategories = Subcategory::all();
            return view('product.add_product', compact('products', 'categories', 'subCategories'));
        } catch (\Exception $e) {
            Log::error('VariantController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            flash()->error('An error occurred while loading the add product page. Please try again.');
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {
        try {
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
                    $fileSize = $img->getSize();
                    $imageName = time() . '_' . $img->getClientOriginalName();
                    $path = public_path('storage/images') . "/" . $imageName;
                    if ($fileSize >= 1024 * 1024) {
                        $manager = new ImageManager(new Driver());
                        $image = $manager->read($img);
                        $image->toJpeg(50)->save($path);
                    } else {
                        $img->storeAs('images', $imageName, 'public');
                    }
                    $variant->images()->create([
                        'path' => $imageName
                    ]);
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
        flash()->success('Product created successfully!');
        return redirect()->route('products.index');
        } catch (\Exception $e) {
            Log::error('VariantController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            flash()->error('An error occurred while creating the product. Please try again.');
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                flash()->error('Product not found.');
                return redirect()->back();
            }
            return view('product.restock_product', compact('product'));
        } catch (\Exception $e) {
            Log::error('VariantController show error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $id
            ]);

            flash()->error('An error occurred while loading the product. Please try again.');
            return redirect()->back();
        }
    }

    public function update(Request  $request, Product $product)
    {
        try {
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
        $product->update([
            'name' => $request->input('product_name'),
            'subcategory_id' => $subCategory !== null ? $subCategory->id : $request->sub_category_id,
            'description' => $request->input('product_description')
        ]);

        $colors = $request->input("color");
        $sizes = $request->input("size");
        $quantities = $request->quantity;
        $images = $request->file('variant_images');
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
                            $fileSize = $img->getSize();
                            $path = public_path('storage/images') . "/" . $imageName;
                            if ($fileSize >= 1024 * 1024) {
                                $manager = new ImageManager(new Driver());
                                $image = $manager->read($img);
                                $image->toJpeg(50)->save($path);
                            } else {
                                $img->storeAs('images', $imageName, 'public');
                            }
                            $variant->images()->create([
                                'path' => $imageName
                            ]);
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
        flash()->success('Product updated successfully!');
        return redirect()->route('products.index');
        } catch (\Exception $e) {
            Log::error('VariantController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $product->id
            ]);

            flash()->error('An error occurred while updating the product. Please try again.');
            return redirect()->back();
        }
    }

    public function restock(Request $request, Product $product)
    {
        try {
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
            flash()->success('Product restocked successfully!');
            return back();
        } catch (\Exception $e) {
            Log::error('VariantController restock error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'product_id' => $product->id
            ]);

            flash()->error('An error occurred while restocking the product. Please try again.');
            return back();
        }
    }
    public function destroy($id)
    {
        try {
            $variant = Variant::find($id);
            if (!$variant) {
                return response()->json(['error' => 'Variant not found'], 404);
            }
            $variant->delete();
            return response()->json(['message' => 'Variant deleted successfully'], 200);
        } catch (\Exception $e) {
            Log::error('VariantController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'variant_id' => $id
            ]);

            return response()->json(['error' => 'An error occurred while deleting the variant'], 500);
        }
    }
}
