<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            "attribute" => "string|min:1",
            "filter" => "string|min:1",
            "with" => "string|min:1|required_with:filterWith",
            "filterWith" => "string|min:1"
        ];
    }
}
