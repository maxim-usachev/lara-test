<?php

namespace App\DTO;

class JWTTokenDTO
{
    public string $token;

    /**
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            'access_token' => $this->token,
            'token_type' => 'bearer',
            'expires_in' => 600,
        ];
    }
}
