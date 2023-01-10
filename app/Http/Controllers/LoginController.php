<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserIndexRequest;
use App\Services\LoginService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginService $loginService,
    ) {
    }

    public function index(UserIndexRequest $request): JsonResponse
    {
        $validated = $request->validate();

        if (! $validated->isValid()) {
            return response()->json($validated->erros(), Response::HTTP_BAD_REQUEST);
        }

        $accessToken = $this->loginService->access(
            $request->json()->get('email'),
            $request->json()->get('password')
        );

        if (! $accessToken) {
            return response()->json(
                [
                    'error' => 'E-mail ou senha inválidos!'
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }

        return response()->json($accessToken, Response::HTTP_OK);
    }
}
