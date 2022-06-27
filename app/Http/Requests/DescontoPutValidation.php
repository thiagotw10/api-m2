<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescontoPutValidation extends FormRequest
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
            'cupom' => 'unique:descontos',
            'porcentagem_desconto' => 'integer | min: 1 | max: 100'
        ];
    }

    public function messages()
    {
        return [
            'cupom.unique' => 'Esse cupom já existe.',
            'valor_desconto_porcentagem.max' => 'O valor máximo desse campo é de 100%.',
            'valor_desconto_porcentagem.min' => 'O valor minimo desse campo é de 1%.',
        ];
    }
}
