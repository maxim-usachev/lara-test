<?php

namespace App\Services\Infrastructure;

class EmailSenderService
{
    public function __invoke(int $userId)
    {
        echo 'Send email to user id: ' . $userId . PHP_EOL;
    }
}
