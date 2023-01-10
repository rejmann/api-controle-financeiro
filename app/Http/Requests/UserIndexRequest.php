<?php

namespace App\Http\Requests;

class UserIndexRequest extends RequestAbstract
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Favor preencher o campo de e-mail!',
            'email.email' => 'O campo e-mail deve ser do tipo e-mail!',
            'password.required' => 'Favor preencher o campo de senha!'
        ];
    }
}
