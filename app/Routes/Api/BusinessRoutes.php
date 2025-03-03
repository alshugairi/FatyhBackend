<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\BusinessController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class BusinessRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['optional.auth']], routes: static function () {
            self::businessRoute();
        });
    }

    private static function businessRoute(): void
    {
        Route::get(uri: 'business/{id}', action: [BusinessController::class, 'home']);
        Route::get(uri: 'business/{id}/reviews', action: [BusinessController::class, 'reviews']);
    }
}
