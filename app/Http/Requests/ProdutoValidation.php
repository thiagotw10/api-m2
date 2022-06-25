<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoValidation extends FormRequest
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
            'produto' => 'required|unique:produtos',
            'preco' => 'required',
            'campanha' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'produto.required' => 'Campo produto é obrigátorio.',
            'produto.unique' => 'Esse produto já existe.',
            'preco.required' => 'Campo preço é obrigátorio.',
            'campanha.required' => 'Campo campanha é obrigátorio.',
        ];
    }
}
