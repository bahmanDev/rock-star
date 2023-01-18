<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'product' => 'sometimes|array',
            'product.name' => 'sometimes|string|min:2|max:100',
            'product.price' => 'sometimes|numeric|min:1',
            'product.options_name' => 'sometimes|min:2|max:100',
            'options' => 'sometimes|array',
            'options.*.id' => 'required|numeric|min:2|max:100',
            'options.*.name' => 'required|string|min:2|max:100'
        ];
    }
}
