<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoValidation extends FormRequest
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
            'grupo' => 'required|unique:grupos'
        ];
    }

    public function messages()
    {
        return [
            'grupo.required' => 'Campo grupo é obrigátorio.',
            'grupo.unique' => 'Esse grupo já existe.'
        ];
    }
}
