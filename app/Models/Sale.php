<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['total_price', 'sold_data', 'customer_id', 'seller_id', 'car_id', "payment_method_id"];

    public function car(){
        return $this->belongsTo("App\Models\Car");
    }

    public function customer(){
        return $this->belongsTo("App\Models\Customer");
    }

    public function seller(){
        return $this->belongsTo("App\Models\Seller");
    }

    public function paymentMethod(){
        return $this->belongsTo("App\Models\PaymentMethod");
    }
}
