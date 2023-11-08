<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            "sold_data"=>"required|date",
            "customer_id"=>"required|exists:customers,id|integer",
            "seller_id"=>"required|exists:sellers,id|integer",
            "car_id"=>"required|exists:cars,id|integer",
            "payment_method_id"=>"required|exists:payment_methods,id|integer"
        ];
    }
}
