<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModel extends Model
{
    use HasFactory;

    protected $fillable = ["name", "year", "doors", "seat", "airbag", "abs", "brand_id"];

    public function cars(){
        return $this->hasMany("App\Models\Car");
    }

    public function brand(){
        return $this->belongsTo("App\Models\Brand");
    }
}
