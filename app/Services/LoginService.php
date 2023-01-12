<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly TokenService $tokenService
    ){
    }

    public function access(string $email, string $password): array|false
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if (! $user || ! $this->passwordCheck($user, $password)) {
            return false;
        }

        return $this->tokenService->generate(
            [
                'email' => $email,
                'exp'   => (new \DateTime('+1 hour'))->getTimestamp(),
            ],
            env('JWT_KEY')
        );
    }

    private function passwordCheck(?Model $user, string $password): bool
    {
        return Hash::check($password, $user->getAttribute('password'));
    }
}
