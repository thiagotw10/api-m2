<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CampanhaValidation extends FormRequest
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
            'campanha' => 'required|unique:campanhas',
            'grupo' => 'required',
            'descricao' => 'required',
            'url_imagem' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'campanha.required' => 'Campo campanha é obrigátorio.',
            'descricao.required' => 'Campo descrição é obrigátorio.',
            'url_imagem.required' => 'Campo url_imagem é obrigátorio.',
            'campanha.unique' => 'Essa campanha já existe.',
            'grupo.required' => 'Campo grupo é obrigátirio.',
            'status.required' => 'Campo status é obrigátirio.',
        ];
    }
}
