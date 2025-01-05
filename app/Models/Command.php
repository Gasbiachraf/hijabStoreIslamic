<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    //
    protected $fillable = [
        "status",
        "livraison",
        "client_id"
    ];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function variants(){
        return $this->belongsToMany(Variant::class , 'command_variants');
    }
}
