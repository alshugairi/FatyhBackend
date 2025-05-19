<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Checkout\CartController,
    Http\Controllers\Api\Checkout\OrderController,
    Http\Controllers\Api\Checkout\CouponController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class CheckoutRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['optional.auth']], routes: static function () {

            Route::get(uri: 'cart', action: [CartController::class, 'index']);
            Route::post('cart', [CartController::class, 'store']);
            Route::delete('cart', [CartController::class, 'removeFromCart']);
            Route::get('cart/session', [CartController::class, 'getSessionId']);
            Route::post('cart/increase', [CartController::class, 'increaseQuantity']);
            Route::post('cart/decrease', [CartController::class, 'decreaseQuantity']);
            Route::post('orders', [OrderController::class, 'store']);
            Route::get('orders/{id}', [OrderController::class, 'show']);
            Route::get('coupons/{code}', [CouponController::class, 'getByCode']);
        });
    }
}
