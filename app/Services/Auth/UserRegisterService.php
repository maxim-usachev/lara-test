<?php

namespace App\Services\Auth;

use App\DTO\UserRegisterDTO;
use App\Events\userRegisteredEvent;
use App\Exceptions\UserRegistrationException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRegisterService
{
    private userRegisteredEvent $userRegisteredEvent;

    /**
     * @param userRegisteredEvent $userRegisteredEvent
     */
    public function __construct(userRegisteredEvent $userRegisteredEvent)
    {
        $this->userRegisteredEvent = $userRegisteredEvent;
    }

    /**
     * @throws UserRegistrationException
     */
    public function __invoke(UserRegisterDTO $userRegisterDTO): ?User
    {
        $validator = Validator::make($userRegisterDTO->toArray(), [
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if($validator->fails()) {
            throw new UserRegistrationException($validator->errors()->toJson(JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 422);
        }

        $createdUser =  User::create(
            $userRegisterDTO->email,
            Hash::make($userRegisterDTO->password)
        );

        $this->userRegisteredEvent::dispatch($createdUser);

        return $createdUser;
    }
}
