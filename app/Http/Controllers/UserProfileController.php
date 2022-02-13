<?php

namespace App\Http\Controllers;

use App\DTO\UserProfileUpdateDTO;
use App\Services\UserProfile\UserProfileGetService;
use App\Services\UserProfile\UserProfileUpdateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    private UserProfileGetService $userProfileGetService;

    private UserProfileUpdateService $userProfileUpdateService;

    /**
     * @param UserProfileGetService $userProfileGetService
     * @param UserProfileUpdateService $userProfileUpdateService
     */
    public function __construct(UserProfileGetService $userProfileGetService, UserProfileUpdateService $userProfileUpdateService)
    {
        $this->middleware('auth:api');
        $this->userProfileGetService = $userProfileGetService;
        $this->userProfileUpdateService = $userProfileUpdateService;
    }

    public function getProfile(int $userId): JsonResponse
    {
        return response()->json($this->userProfileGetService->__invoke($userId));
    }

    public function patchProfile(Request $request, int $userId)
    {
        $lang = $request->post('lang');
        $timezone = $request->post('timezone');
        $userProfileUpdateDTO = new UserProfileUpdateDTO($lang, $timezone);
        return response()->json($this->userProfileUpdateService->__invoke($userId, $userProfileUpdateDTO));
    }
}
