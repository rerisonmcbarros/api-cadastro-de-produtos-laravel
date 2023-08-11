<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
                "unique:products,code,{$this->id},id"
            ],
            'description' => [
                'required',
                'max:255',
                "unique:products,code,{$this->id},id"
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
                'nullable',
                'integer',
                'min:0'
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
            'storage' => 'estoque'
        ];
    }
}
