<?php

namespace App\Services\UserProfile;

use App\DTO\UserProfileUpdateDTO;
use App\Models\UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class UserProfileUpdateService
{
    private UserProfileGetService $userProfileGetService;

    /**
     * @param UserProfileGetService $userProfileGetService
     */
    public function __construct(UserProfileGetService $userProfileGetService)
    {
        $this->userProfileGetService = $userProfileGetService;
    }

    /**
     * @param int $userId
     * @param UserProfileUpdateDTO $userProfileUpdateDTO
     * @return UserProfile
     * @throws ModelNotFoundException
     */
    public function __invoke(int $userId, UserProfileUpdateDTO $userProfileUpdateDTO): UserProfile
    {
        $validator = Validator::make($userProfileUpdateDTO->toArray(), [
            'lang' => 'required|string',
            'timezone' => 'required|string',
        ]);

        if($validator->fails()) {
            throw new BadRequestException($validator->errors()->toJson(JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), 422);
        }

        /** @var UserProfile $userProfile */
        $userProfile = $this->userProfileGetService->__invoke($userId);
        $userProfile->update($userProfileUpdateDTO->toArray());
        $userProfile->save();

        return $userProfile;
    }
}
