<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            "car_model_id" => "integer|exists:car_models,id",
            "price" => "numeric|min:1",
            "km" => "numeric|min:0",
            "image" => "file|max:5120",
            "sold"=>"boolean"
        ];
    }
}
