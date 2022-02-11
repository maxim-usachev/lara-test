<?php

namespace App\Services;

class UserLogoutService
{
    public function __invoke()
    {
        auth()->logout();
    }
}
