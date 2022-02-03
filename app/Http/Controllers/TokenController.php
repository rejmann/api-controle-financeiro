<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TokenController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createToken(Request $request)
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
