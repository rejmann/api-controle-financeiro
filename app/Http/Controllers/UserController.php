<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // Valida post
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|max:500'
            ],
            [
                'name.required' => 'Favor preencher o campo de nome!',
                'email.required' => 'Favor preencher o campo de e-mail!',
                'email.email' => 'O campo e-mail deve ser do tipo e-mail!',
                'password.required' => 'Favor preencher o campo de senha!'
            ]
        );

        // Verifica se existe e se a senha é valida
        if(!is_null(User::where('email', $request->email)->first())){
            return response()
                ->json(['error' => "E-mail já cadastrado!"]
                    , 409);
        }

        // Retorna o cadastro em json do usuário cadastrado.
        return response()
            ->json(User::create($request->all(), 201));
    }
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function tokenGenerator(Request $request)
    {
        // Valida post
        $this->validate(
            $request,
            [
                'email' => 'required|email',
                'password' => 'required'
            ]
        );

        // Busca usuário
        $user = User::where('email', $request->email)->first();

        // Verifica se existe e se a senha é valida
        if(is_null($user) || !Hash::check($request->password, $user->password)){
            return response()
                ->json('', 401);
        }

        // Gera token
        $token = JWT::encode(
            ['email' => $request->email],
            env('JWT_KEY'),
            'HS256'
        );

        return [
            'access_token' => $token
        ];
    }
}
