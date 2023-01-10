<?php

namespace App\Http\Requests;

class MovimentUpdateRequest extends RequestAbstract
{
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'value' => 'required',
            'date' => 'required|date',
            'category' => 'string',
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'O recurso description é obrigatório',
            'description.string' => 'O recurso description esperado deve ser do tipo string',
            'description.max' => 'O recurso description esperado deve conter no máximo 255 caracteres',
            'value.required' => 'O recurso value é obrigatório',
            'date.required' => 'O recurso date é obrigatório',
        ];
    }
}
