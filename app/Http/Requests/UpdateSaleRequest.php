<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "total_price"=>"numeric",
            "sold_data" => "date",
            "customer_id" => "exists:customers,id|integer",
            "seller_id" => "exists:sellers,id|integer",
            "car_id" => "exists:cars,id|integer",
            "payment_method_id" => "exists:payment_methods,id|integer"
        ];
    }
}
