<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class arrivalproduct extends Model
{
    //
    protected $fillable = [
        "arrivalDate",
        "quantity",
        "size_id",
    ];

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
