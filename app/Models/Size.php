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

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }
}
