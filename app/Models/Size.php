<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'size',
        'quantity',
        'variant_id'
    ];

    // Available sizes constant
    public const AVAILABLE_SIZES = [
        'XS',
        'S',
        'Standard',
        'M',
        'L',
        'XL',
        'XXL',
        'XXXL',
        'One Size'
    ];

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function arrival(){
        return $this->hasMany(arrivalproduct::class);
    }

    /**
     * Get all available sizes for a variant with their current quantities
     */
    public static function getAllSizesForVariant($variantId)
    {
        $existingSizes = self::where('variant_id', $variantId)->pluck('quantity', 'size')->toArray();

        $allSizes = [];
        foreach (self::AVAILABLE_SIZES as $size) {
            $allSizes[] = [
                'size' => $size,
                'quantity' => $existingSizes[$size] ?? 0,
                'exists' => isset($existingSizes[$size])
            ];
        }

        return $allSizes;
    }
}
