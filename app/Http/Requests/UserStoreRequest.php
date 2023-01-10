<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Unique;

class UserStoreRequest extends RequestAbstract
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                (new Unique('users', 'email'))->ignore('id'),
            ],
            'password' => 'required|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Favor preencher o campo de nome!',
            'email.required' => 'Favor preencher o campo de e-mail!',
            'email.email' => 'O campo e-mail deve ser do tipo e-mail!',
            'password.required' => 'Favor preencher o campo de senha!',
            'password.max' => 'O campo de senha deve ter no máximo 500 caracteres!',
            'unique' => 'O e-mail informado já está cadastrado!',
        ];
    }
}
