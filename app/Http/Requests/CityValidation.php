<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityValidation extends FormRequest
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
            'cidade' => 'required|unique:cidades',
            'grupo' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cidade.required' => 'Campo cidade é obrigátorio.',
            'cidade.unique' => 'Essa cidade já existe.',
            'grupo.required' => 'Campo grupo é obrigátirio.'
        ];
    }
}
