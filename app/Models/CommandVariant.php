<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandVariant extends Model
{
    //
    protected $fillable =[
        "quantity",
        "salePrice",
        "size",
        "command_id",
        "variant_id",
    ];
    public function variant()
{
    return $this->belongsTo(Variant::class);
}

    
}
