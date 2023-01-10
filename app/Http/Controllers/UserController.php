<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        protected readonly UserRepository $userRepository
    ){
    }

    public function store(UserStoreRequest $request): JsonResponse
    {
        $validated = $request->validate();

        if (! $validated->isValid()) {
            return response()->json($validated->erros(), Response::HTTP_BAD_REQUEST);
        }

        return response()->json(
            $this->userRepository->create($request->json()->all()),
            Response::HTTP_CREATED
        );
    }
}
