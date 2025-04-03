<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Authentication\AuthenticationController,
    Http\Controllers\Api\Authentication\VerificationController,
    Http\Controllers\Api\Authentication\ProfileController,
    Http\Controllers\Api\Authentication\PasswordController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class AuthenticationRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        Route::group(attributes: [], routes: static function () {
            Route::post(uri: 'login', action: [AuthenticationController::class, 'login'])->middleware('throttle:5,1');
            Route::post(uri: 'social/login', action: [AuthenticationController::class, 'socialLogin'])->middleware('throttle:5,1');

            Route::post(uri: 'register', action: [AuthenticationController::class, 'register']);
            Route::post(uri: 'social/register', action: [AuthenticationController::class, 'socialRegister']);
            Route::post(uri: 'resend-OTP-without-token', action: [VerificationController::class, 'resendOTPWithoutToken'])->middleware('throttle:5,1');
            Route::post(uri: 'check-username', action: [AuthenticationController::class, 'checkUsername']);
        });

        Route::group(attributes: ['middleware' => [ 'auth:sanctum']], routes: static function () {

            Route::post(uri: 'verify', action: [VerificationController::class, 'verify']);
            Route::post(uri: 'resend-OTP', action: [VerificationController::class, 'resendOTP'])->middleware('throttle:5,1');

            Route::group(attributes: [], routes: static function () {
                Route::post(uri: 'logout', action: [AuthenticationController::class, 'logout']);
                Route::post(uri: 'refresh-token', action: [AuthenticationController::class, 'refreshToken']);
                Route::post(uri: 'reset-password', action: [PasswordController::class, 'resetPassword']);
                Route::post(uri: 'change-password', action: [PasswordController::class, 'changePassword']);
                Route::get(uri: 'profile', action: [ProfileController::class, 'index']);
                Route::post(uri: 'profile', action: [ProfileController::class, 'update']);
                Route::delete(uri: 'delete-account', action: [AuthenticationController::class, 'deleteAccount']);
                Route::post(uri: 'request-delete', action: [AuthenticationController::class, 'requestDelete']);
                Route::post(uri: 'request-data', action: [AuthenticationController::class, 'requestData']);
            });
        });
    }
}
