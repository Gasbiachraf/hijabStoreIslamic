<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        "name",
        "subcategory_id",
        "description",
    ];


    public function subcategory (){
        return $this->belongsTo(Subcategory::class);
    }

    public function inventories(){
        return $this->hasMany(Inventory::class);
    }
}
