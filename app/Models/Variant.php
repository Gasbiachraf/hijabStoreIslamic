<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    //
    protected $fillable = [
        "color",
        "image",
        "inventory_id",
    ] ;

    public function inventory(){
        return $this->belongsTo(Inventory::class);
    }
    public function arrivalproducts(){
        return $this->hasMany(arrivalproduct::class);
    }
    public function commands(){
        return $this->belongsToMany(Command::class , 'command_variants');
    }
    
    public function images() {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function sizes(){
        return $this->hasMany(Size::class);
    }

}
