<?php

namespace App\Http\Controllers;

use App\DTO\UserLoginDTO;
use App\DTO\UserRegisterDTO;
use App\Exceptions\UserLoginValidationException;
use App\Exceptions\UserRegistrationException;
use App\Services\UserLoginService;
use App\Services\UserLogoutService;
use App\Services\UserRefreshTokenService;
use App\Services\UserRegisterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    private UserRegisterService $userRegisterService;
    private UserLoginService $userLoginService;
    private UserLogoutService $userLogoutService;
    private UserRefreshTokenService $userRefreshTokenService;

    /**
     * Create a new AuthController instance.
     *
     * @param UserRegisterService $userRegisterService
     * @param UserLoginService $userLoginService
     * @param UserLogoutService $userLogoutService
     * @param UserRefreshTokenService $userRefreshTokenService
     */
    public function __construct(
        UserRegisterService $userRegisterService,
        UserLoginService $userLoginService,
        UserLogoutService $userLogoutService,
        UserRefreshTokenService $userRefreshTokenService
    ) {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->userRegisterService = $userRegisterService;
        $this->userLoginService = $userLoginService;
        $this->userLogoutService = $userLogoutService;
        $this->userRefreshTokenService = $userRefreshTokenService;
    }

    /**
     * Register user.
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $passwordConfirmation = $request->post('password_confirmation');
        $userRegisterDTO = new UserRegisterDTO($email, $password, $passwordConfirmation);

        try {
            $user = $this->userRegisterService->__invoke($userRegisterDTO);
        } catch (UserRegistrationException $e) {
            return response()->json([
                    'message' => \json_decode($e->getMessage(), true),
                    'code' => $e->getCode(),
                ]);
        }

        return response()->json([
            'message' => 'User successfully registered',
            'userId' => $user->id,
        ], 201);
    }

    /**
     * login user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $email = $request->post('email');
        $password = $request->post('password');
        $userLoginDTO = new UserLoginDTO($email, $password);

        try {
            $jwtTokenDTO = $this->userLoginService->__invoke($userLoginDTO);
        } catch (UserLoginValidationException $e) {
            return response()->json([
                'message' => \json_decode($e->getMessage(), true),
                'code' => $e->getCode(),
            ]);
        } catch (UnauthorizedException $ex) {
            return response()->json([
                'message' => ['error' => 'Unauthorized'],
                'code' => $ex->getCode(),
            ]);
        }

        return response()->json($jwtTokenDTO->toArray(), 200);
    }

    /**
     * Logout user
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->userLogoutService->__invoke();

        return response()->json(['message' => 'User successfully logged out.']);
    }

    /**
     * Refresh token.
     *
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $newJWTToken = $this->userRefreshTokenService->__invoke();

        return response()->json($newJWTToken->toArray(), 200);
    }
}
