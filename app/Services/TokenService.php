<?php

namespace App\Services;

use Firebase\JWT\JWT;

class TokenService
{
    public function generate(array $payload, string $key, string $algorithm = 'HS256'): array
    {
        return [
            'access_token' => JWT::encode($payload, $key, $algorithm)
        ];
    }
}

