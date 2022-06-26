<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescontoValidation extends FormRequest
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
            'cupom' => 'required|unique:descontos',
            'produto' => 'required',
            'porcentagem_desconto' => 'required|integer|min: 1|max: 100',
            'status' => 'required'
        ];
    }


    public function messages()
    {
        return [
            'cupom.required' => 'Campo cupom é obrigátorio.',
            'cupom.unique' => 'Esse cupom já existe.',
            'status.required' => 'Campo status é obrigátorio.',
            'porcentagem_desconto.required' => 'Campo porcentagem_desconto é obrigátorio.',
        ];
    }
}
