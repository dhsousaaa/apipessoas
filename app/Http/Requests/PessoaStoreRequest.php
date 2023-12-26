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
            'endereco' => 'required|string|max:100',
            'telefone' => 'required|string|max:20',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O nome não foi informado.',
            'nome.max' => 'O nome não pode ultrapassar de 20 caracteres.',
            'sobrenome.required' => 'O sobrenome não foi informado.',
            'sobrenome.max' => 'O sobrenome não pode ultrapassar de 20 caracteres.',
            'data_nascimento.required' => 'Data de nascimento não foi informada.',
            'data_nascimento.date_format' => 'Data de nascimento deve estar no formato Y-m-d.',
            'telefone.max' => 'O telefone não pode ultrapassar de 20 caracteres.',
            'telefone.required' => 'O telefone não foi informado.',
            'endereco.max' => 'O endereço não pode ultrapassar de 100 caracteres.',
            'endereco.required' => 'O endereço não foi informado.',
        ];
    }
}
