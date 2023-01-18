<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product' => 'required|array',
            'product.name' => 'required|unique:products,name|string|min:2|max:100',
            'product.price' => 'required|numeric|min:1',
            'product.options_name' => 'required|unique:products,options_name|min:2|max:100',
            'options' => 'required|array',
            'options.*.name' => 'required|unique:options,name|string|min:2|max:100'
        ];
    }
}
