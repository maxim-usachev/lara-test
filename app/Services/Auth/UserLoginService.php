<?php

namespace App\Services\Auth;

use App\DTO\JWTTokenDTO;
use App\DTO\UserLoginDTO;
use App\Exceptions\UserLoginValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;

class UserLoginService
{
    /**
     * @throws UserLoginValidationException
     * @throws UnauthorizedException
     */
    public function __invoke(UserLoginDTO $userLoginDTO): JWTTokenDTO
    {
        $validator = Validator::make($userLoginDTO->toArray(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()) {
            throw new UserLoginValidationException($validator->errors()->toJson(JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 422);
        }

        try {
            if (!$token = auth()->attempt($validator->validated())) {
                throw new UnauthorizedException();
            }
        } catch (ValidationException $e) {
            throw new UnauthorizedException();
        }

        return new JWTTokenDTO($token);
    }
}
