<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandVariant extends Model
{
    //
    protected $fillable =[
        "quantity",
        "salePrice",
        "command_id",
        "variant_id",
    ];

    
}
