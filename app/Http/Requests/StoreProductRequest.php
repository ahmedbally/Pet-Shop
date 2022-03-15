<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'price' => [
                'required',
                'decimal',
            ],
            'description' => [
                'required',
                'string',
            ],
            'category' => [
                'required',
                Rule::exists('categories', 'uuid'),
            ],
            'brand' => [
                'required',
                Rule::exists('brands', 'uuid'),
            ],
            'image' => [
                'required',
                Rule::exists('files', 'uuid'),
            ],
        ];
    }
}
