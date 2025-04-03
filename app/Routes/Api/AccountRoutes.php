<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Account\AccountController,
    Http\Controllers\Api\Account\ProfileController,
    Http\Controllers\Api\Account\AddressController,
    Http\Controllers\Api\Account\ReviewController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class AccountRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['auth:sanctum'], 'prefix' => 'account'], routes: static function () {

            Route::get(uri: 'profile', action: [ProfileController::class, 'profile']);
            Route::post(uri: 'profile', action: [ProfileController::class, 'updateProfile']);
            Route::post(uri: 'change-password', action: [ProfileController::class, 'changePassword']);
            Route::post(uri: 'notifications', action: [ProfileController::class, 'updateNotificationSettings']);

            Route::get(uri: 'questions', action: [AccountController::class, 'questions']);
            Route::get(uri: 'coupons', action: [AccountController::class, 'coupons']);
            Route::get(uri: 'addresses', action: [AddressController::class, 'index']);
            Route::get(uri: 'reviews', action: [ReviewController::class, 'index']);
        });
    }
}
