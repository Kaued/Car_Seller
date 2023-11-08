<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = ["car_model_id", "price", "km", "sold", "image_url"];

    public function carModel(){
        return $this->belongsTo("App\Models\CarModel");
    }

    public function sell(){
        return $this->hasOne("App\Models\Sale");
    }
}
