<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Checkout\CartController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class CheckoutRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['optional.auth']], routes: static function () {

            Route::get(uri: 'cart', action: [CartController::class, 'index']);
        });
    }
}
