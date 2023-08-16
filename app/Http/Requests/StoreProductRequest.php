<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
            ],
            'code' => [
                'required',
                'numeric',
                'max_digits:255',
                'unique:products'
            ],
            'description' => [
                'required',
                'max:255',
                'unique:products'
            ],
            'purchase_price' => [
                'required',
                'numeric'
            ],
            'sale_price' => [
                'required',
                'numeric'
            ],
            'storage' => [
                'required',
                'integer',
                'min:0'
            ],
            'images.*' => [
                'nullable',
                'image',
                'mimes:jpeg,jpg,png'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'código',
            'description' => 'descrição',
            'purchase_price' => 'preço de compra',
            'sale_price' => 'preço de venda',
            'storage' => 'estoque',
            'images' => 'imagem'
        ];
    }
}
