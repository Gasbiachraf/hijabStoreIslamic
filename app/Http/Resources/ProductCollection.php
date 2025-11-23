<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($product) {
            // Process inventories and filter out empty ones
            $inventories = $product->inventories->map(function ($inventory) {
                // Filter variants to only include those with quantity > 0
                $variants = $inventory->variants->filter(function ($variant) {
                    // Only include variants that have at least one size with quantity > 0
                    return $variant->sizes->sum('quantity') > 0;
                })->map(function ($variant) {
                    // Filter sizes to only include those with quantity > 0
                    $sizes = $variant->sizes->filter(function ($size) {
                        return $size->quantity > 0;
                    })->map(function ($size) {
                        return [
                            'size' => $size->size,
                            'quantity' => $size->quantity
                        ];
                    })->values();
                    
                    return [
                        'images' => $variant->images->map(function ($img){
                            return $img->path;
                        }),
                        'color' => $variant->color,
                        'volumes' => $sizes
                    ];
                })->values();
                
                // Only include inventory if it has variants with quantity > 0
                if ($variants->isEmpty()) {
                    return null;
                }
                
                return [
                    'prePrice' => $inventory->prePrice,
                    'postPrice' => $inventory->postPrice,
                    'exPrice' => $inventory->exPrice,
                    'type' => $inventory->type,
                    'variants' => $variants
                ];
            })->filter(function ($inventory) {
                // Remove null inventories (those with no variants)
                return $inventory !== null;
            })->values();
            
            // Only include product if it has inventories with variants
            if ($inventories->isEmpty()) {
                return null;
            }
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'subcategory' => $product->subcategory->name,
                'category' => $product->subcategory->category->name,
                'inventories' => $inventories
            ];
        })->filter(function ($product) {
            // Remove null products (those with no inventories)
            return $product !== null;
        })->values()->toArray();
    }
}
