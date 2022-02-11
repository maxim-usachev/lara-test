<?php

namespace App\Services;

use App\DTO\JWTTokenDTO;

class UserRefreshTokenService
{
    public function __invoke(): JWTTokenDTO
    {
        $newToken = auth()->refresh();

        return new JWTTokenDTO($newToken);
    }
}
