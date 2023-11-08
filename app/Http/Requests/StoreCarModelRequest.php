<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarModelRequest extends FormRequest
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
            "name"=>"required|unique:car_models",
            "year"=>"required|integer|min:1800",
            "doors"=>"required|integer",
            "seat"=>"required|integer|min:1",
            "airbag"=>"required|boolean",
            "abs"=>"required|boolean",
            "brand_id"=>"required|exists:brands,id"
        ];
    }
}
