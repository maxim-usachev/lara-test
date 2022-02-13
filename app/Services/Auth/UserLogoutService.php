<?php

namespace App\Services\Auth;

class UserLogoutService
{
    public function __invoke()
    {
        auth()->logout();
    }
}
