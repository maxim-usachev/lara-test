<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::get('/profile/for_user/{userId}', [UserProfileController::class, 'getProfile']);
    Route::patch('/profile/for_user/{userId}', [UserProfileController::class, 'patchProfile']);
});

