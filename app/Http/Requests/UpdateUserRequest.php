<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'max:255'],
            'email' => [
                'required', 
                'email', 
                "unique:users,email,{$this->id},id", 
                'max:255'
            ],
            'password' => [
                'required', 
                Password::min(8)->numbers()->letters(), 
                'max:255',
                'confirmed'
            ],
            'is_admin' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'password' => 'senha',
            'is_admin' => 'administrador'
        ];
    }
}
