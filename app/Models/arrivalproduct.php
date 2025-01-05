<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class arrivalproduct extends Model
{
    //
    protected $fillable = [
        "arrivalDate",
        "description",
        "variant_id",
    ];
}
