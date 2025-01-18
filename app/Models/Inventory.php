<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\type;

class Inventory extends Model
{
    //
    protected $fillable = [
    "prePrice",
    "postPrice",
    "exPrice",
    "type",
    "product_id"
    ];

    protected $casts = [
        "type" => "object"
    ];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function variants(){
        return $this->hasMany(Variant::class);
    }
}
