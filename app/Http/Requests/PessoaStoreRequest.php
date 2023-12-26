<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PessoaStoreRequest extends FormRequest
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
            'nome' => 'required|string|max:20',
            'sobrenome' => 'required|string|max:20',
            'email' => 'required|email|unique:pessoas,email',
            'data_nascimento' => 'required|date_format:Y-m-d',
            'endereco' => 'required|string',
            'telefone' => 'required|string',
        ];
    }
}
