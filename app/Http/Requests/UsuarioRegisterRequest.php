<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuarioRegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50',
            'password' => 'required|string|min:8|max:20',
            'email' => 'required|unique:users'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome não foi informado.',
            'name.max' => 'O nome não pode ter mais de 50 caracteres.',
            'password.required' => 'Senha não foi informada.',
            'password.min' => 'Senha precisa ter no mínimo 8 caracteres.',
            'password.max' => 'Senha não pode ter mais de 20 caracteres',
            'email.unique' => 'Este e-mail já está cadastrado.'
        ];
    }
}
