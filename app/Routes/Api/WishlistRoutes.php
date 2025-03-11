<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\WishlistController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class WishlistRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['auth:sanctum']], routes: static function () {

            Route::get(uri: 'wishlist', action: [WishlistController::class, 'index']);
            Route::post('wishlist', [WishlistController::class, 'addToWishlist']);
            Route::delete('wishlist', [WishlistController::class, 'removeFromWishlist']);

        });
    }
}
