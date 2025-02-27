<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Account\AccountController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class AccountRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['auth:sanctum'], 'prefix' => 'account'], routes: static function () {

            Route::get(uri: 'profile', action: [AccountController::class, 'profile']);
        });
    }
}
