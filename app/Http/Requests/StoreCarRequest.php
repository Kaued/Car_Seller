<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
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
            "car_model_id"=>"required|integer|exists:car_models,id",
            "price"=>"required|numeric|min:1",
            "km"=>"required|numeric|min:0",
            "image"=>"required|file|max:5120"
        ];
    }
}
