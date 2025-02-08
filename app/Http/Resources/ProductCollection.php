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
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'subcategory' => $product->subcategory->name,
                'category' => $product->subcategory->category->name,
                'inventories' => $product->inventories->map(function ($inventory) {
                    return [
                        'prePrice' => $inventory->prePrice,
                        'postPrice' => $inventory->postPrice,
                        'exPrice' => $inventory->exPrice,
                        'type' => $inventory->type,
                        'variants' => $inventory->variants->map(function ($variant) {
                            return [
                                'color' => $variant->color,
                                'volumes' => $variant->sizes->map(function ($volume) {
                                    return [
                                        'size' => $volume->size,
                                        'quantity' => $volume->quantity
                                    ];
                                })
                            ];
                        })
                    ];
                })
            ];
        })->toArray();
    }
}
