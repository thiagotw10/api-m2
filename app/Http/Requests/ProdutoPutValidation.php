<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdutoPutValidation extends FormRequest
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
            'produto' => 'unique:produtos',
            'preco' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'produto.unique' => 'Esse produto já existe.',
            'preco.integer' => 'Preço é do tipo string numero.',
        ];
    }
}
