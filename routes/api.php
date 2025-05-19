<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\{Http\Controllers\Api\HomeController,
    Http\Controllers\Api\NewsletterSubscriptionController,
    Routes\Api\AuthenticationRoutes,
    Routes\Api\AccountRoutes,
    Routes\Api\CatalogRoutes,
    Routes\Api\BusinessRoutes,
    Routes\Api\WishlistRoutes,
    Routes\Api\CheckoutRoutes,
    Routes\Api\GeneralRoutes};


AuthenticationRoutes::registerRoutes();
GeneralRoutes::registerRoutes();
AccountRoutes::registerRoutes();
CatalogRoutes::registerRoutes();
BusinessRoutes::registerRoutes();
WishlistRoutes::registerRoutes();
CheckoutRoutes::registerRoutes();

Route::group(attributes: ['middleware' => ['optional.auth']], routes: static function () {
    Route::get(uri: 'home', action: [HomeController::class, 'index']);
    Route::get(uri: 'extra-home', action: [HomeController::class, 'extraHome']);
    Route::post(uri: 'newsletters/subscriptions', action: [NewsletterSubscriptionController::class, 'store']);
});
