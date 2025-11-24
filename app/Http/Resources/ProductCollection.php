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
            $inventories = $product->inventories->map(function ($inventory) {
                $variants = $inventory->variants->map(function ($variant) {
                    $sizes = $variant->sizes->map(function ($size) {
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
                
                return [
                    'prePrice' => $inventory->prePrice,
                    'postPrice' => $inventory->postPrice,
                    'exPrice' => $inventory->exPrice,
                    'type' => $inventory->type,
                    'variants' => $variants
                ];
            })->values();
            
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'subcategory' => $product->subcategory->name,
                'category' => $product->subcategory->category->name,
                'inventories' => $inventories
            ];
        })->toArray();
    }
}
