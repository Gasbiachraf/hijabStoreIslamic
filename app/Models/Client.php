<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //  
    protected $fillable = [
        "name",
        "GSM",
        "adress",
        "email",
        "historique"
    ];

    public function commands(){
        return $this->hasMany(Command::class);
    }
    

}
