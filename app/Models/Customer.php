<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable=["name", "age"];

    public function shopping(){
        return $this->hasMany("App\Models\Sale");
    }
}
