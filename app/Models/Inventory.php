<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $fillable = [
    "prePrice",
    "postPrice",
    "exPrice",
    "type",
    "description",
    "product_id"
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function variants(){
        return $this->hasMany(Variant::class);
    }
}
