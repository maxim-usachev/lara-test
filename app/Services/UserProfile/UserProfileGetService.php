<?php

namespace App\Services\UserProfile;

use App\Models\UserProfile;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserProfileGetService
{
    /**
     * @param int $userId
     * @return UserProfile
     * @throws ModelNotFoundException
     */
    public function __invoke(int $userId): UserProfile
    {
        return UserProfile::query()->where('user_id', $userId)->firstOrFail();
    }
}
