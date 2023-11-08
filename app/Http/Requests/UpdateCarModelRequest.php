<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarModelRequest extends FormRequest
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
        $id = $this->route("carModel");

        return [
            "name" => "unique:car_models,name,".$id,
            "year" => "integer|min:1800",
            "doors" => "integer",
            "seat" => "integer|min:1",
            "airbag" => "boolean",
            "abs" => "boolean",
            "brand_id" => "exists:brands,id"
        ];
    }
}
