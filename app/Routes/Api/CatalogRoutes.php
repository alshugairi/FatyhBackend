<?php

namespace App\Routes\Api;

use App\{Http\Controllers\Api\Catalog\CategoryController,
    Http\Controllers\Api\Catalog\ProductController,
    Http\Controllers\Api\Catalog\ReviewController,
    Http\Controllers\Api\Catalog\QuestionController,
    Http\Controllers\Api\Catalog\BrandController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class CatalogRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        Route::group(attributes: ['middleware' => ['optional.auth']], routes: static function () {
            self::productsRoute();
            self::categoriesRoute();
            self::brandsRoute();
            self::reviewsRoute();
            self::questionsRoute();
        });
    }

    private static function productsRoute(): void
    {
        Route::get(uri: 'products/{id}', action: [ProductController::class, 'show']);
        Route::get(uri: 'products/{id}/extra-data', action: [ProductController::class, 'extraData']);
    }

    private static function reviewsRoute(): void
    {
        Route::get(uri: 'products/{id}/reviews', action: [ReviewController::class, 'index']);
    }

    private static function questionsRoute(): void
    {
        Route::get(uri: 'products/{id}/questions', action: [QuestionController::class, 'index']);
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
