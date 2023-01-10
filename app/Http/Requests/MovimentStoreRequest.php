<?php

namespace App\Http\Requests;

class MovimentStoreRequest extends RequestAbstract
{
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'value' => 'required|int',
            'date' => 'required|date',
            'type' => 'required|string',
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
            'value.number' => 'O recurso value esperado deve ser do tipo number',
            'date.required' => 'O recurso date é obrigatório',
            'type.required' => 'O recurso type é obrigatório',
            'type.string' => 'O recurso type esperado deve ser do tipo string',
            'category.string' => 'O recurso category esperado deve ser do tipo string',
        ];
    }
}
