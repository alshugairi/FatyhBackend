<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Catalog\CategoryController,
    Http\Controllers\Api\Catalog\BrandController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class CatalogRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        self::categoriesRoute();
        self::brandsRoute();
    }

    private static function categoriesRoute(): void
    {
        Route::get(uri: 'categories', action: [CategoryController::class, 'index']);
    }

    private static function brandsRoute(): void
    {
        Route::get(uri: 'brands', action: [BrandController::class, 'index']);
    }
}
