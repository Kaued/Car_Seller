<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ["name", "image_url"];

    public function models(){
        return $this->hasMany("App\Models\CarModel");
    }
}
