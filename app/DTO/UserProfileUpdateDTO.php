<?php

namespace App\DTO;

use App\Models\User;

class UserProfileUpdateDTO
{
    public User $user;

    public string $lang = 'ru';

    public string $timezone = '0';

    /**
     * @param string $lang
     * @param string $timezone
     */
    public function __construct(User $user, string $lang, string $timezone)
    {
        $this->user = $user;
        $this->lang = $lang;
        $this->timezone = $timezone;
    }

    public function getArray(): array
    {
        return [
            'user' => $this->user,
            'lang' => $this->lang,
            'timezone' => $this->timezone,
        ];
    }
}
