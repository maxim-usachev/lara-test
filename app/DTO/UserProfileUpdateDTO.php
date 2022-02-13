<?php

namespace App\DTO;

use JetBrains\PhpStorm\ArrayShape;

class UserProfileUpdateDTO
{
    public string $lang = 'ru';

    public string $timezone = '0';

    /**
     * @param string $lang
     * @param string $timezone
     */
    public function __construct(string $lang, string $timezone)
    {
        $this->lang = $lang;
        $this->timezone = $timezone;
    }

    #[ArrayShape(['lang' => "string", 'timezone' => "string"])]
    public function toArray(): array
    {
        return [
            'lang' => $this->lang,
            'timezone' => $this->timezone,
        ];
    }
}
