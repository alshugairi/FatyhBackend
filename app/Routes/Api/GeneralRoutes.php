<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\SettingsController,
    Http\Controllers\Api\GeneralController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class GeneralRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        Route::group(attributes: [], routes: static function () {
            Route::get(uri: 'pages/terms', action: [SettingsController::class, 'terms']);
            Route::get(uri: 'pages/privacy', action: [SettingsController::class, 'privacy']);
            Route::get(uri: 'countries', action: [GeneralController::class, 'countries']);
            Route::get(uri: 'cities', action: [GeneralController::class, 'cities']);
            Route::get(uri: 'page/{slug}', action: [GeneralController::class, 'page']);
            Route::get(uri: 'faqs-groups', action: [GeneralController::class, 'faqsGroups']);
            Route::post(uri: 'contact', action: [GeneralController::class, 'contact']);
        });
    }
}
