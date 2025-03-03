<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\{Http\Controllers\Api\HomeController,
    Routes\Api\AuthenticationRoutes,
    Routes\Api\AccountRoutes,
    Routes\Api\CatalogRoutes,
    Routes\Api\BusinessRoutes,
    Routes\Api\GeneralRoutes};


AuthenticationRoutes::registerRoutes();
GeneralRoutes::registerRoutes();
AccountRoutes::registerRoutes();
CatalogRoutes::registerRoutes();
BusinessRoutes::registerRoutes();

//Route::group(attributes: ['middleware' => ['auth:sanctum']], routes: static function () {
//
//});

Route::group(attributes: ['middleware' => ['optional.auth']], routes: static function () {
    Route::get(uri: 'home', action: [HomeController::class, 'index']);
});
