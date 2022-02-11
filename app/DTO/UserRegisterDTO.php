<?php

namespace App\DTO;

class UserRegisterDTO
{
    public ?string $email;
    public ?string $password;
    public ?string $passwordConfirmation;

    /**
     * @param string|null $email
     * @param string|null $password
     * @param string|null $passwordConfirm
     */
    public function __construct(?string $email, ?string $password, ?string $passwordConfirm)
    {
        $this->email = $email;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirm;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
        ];
    }
}
