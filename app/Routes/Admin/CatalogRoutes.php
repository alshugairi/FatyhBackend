<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Catalog\CategoryController,
    Http\Controllers\Admin\Catalog\BrandController,
    Http\Controllers\Admin\Catalog\ProductController,
    Http\Controllers\Admin\Catalog\ProductImageController,
    Http\Controllers\Admin\Catalog\UnitController,
    Http\Controllers\Admin\Catalog\AttributeController,
    Http\Controllers\Admin\Catalog\CollectionController,
    Http\Controllers\Admin\Catalog\CollectionProductController,
    Http\Controllers\Admin\Catalog\AttributeOptionController,
    Http\Controllers\Admin\Catalog\ProductVariantController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class CatalogRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        self::categoriesRoute();
        self::brandsRoute();
        self::productsRoute();
        self::productImagesRoute();
        self::unitsRoute();
        self::attributesRoute();
        self::collectionsRoute();
    }

    /**
     * @return void
     */
    private static function categoriesRoute(): void
    {
        Route::get(uri: 'categories/list', action: [CategoryController::class, 'list'])->name(name: 'categories.list');
        Route::get(uri: 'categories/select', action: [CategoryController::class, 'select'])->name(name: 'categories.select');
        Route::resource(name: 'categories', controller: CategoryController::class);
    }

    /**
     * @return void
     */
    private static function brandsRoute(): void
    {
        Route::get(uri: 'brands/list', action: [BrandController::class, 'list'])->name(name: 'brands.list');
        Route::resource(name: 'brands', controller: BrandController::class);
    }

    /**
     * @return void
     */
    private static function productsRoute(): void
    {
        Route::post(uri: 'products/{product}/update-seo', action: [ProductController::class, 'updateSeo'])->name(name: 'products.seo.update');
        Route::post(uri: 'products/{product}/upload-video', action: [ProductController::class, 'uploadVideo'])->name(name: 'products.videos.upload');
        Route::get(uri: 'products/select', action: [ProductController::class, 'select'])->name(name: 'products.select');
        Route::get(uri: 'products/list-json', action: [ProductController::class, 'listJson'])->name(name: 'products.listJson');
        Route::get(uri: 'products/list', action: [ProductController::class, 'list'])->name(name: 'products.list');
        Route::get('products/export', [ProductController::class, 'export'])->name('products.export');
        Route::resource(name: 'products', controller: ProductController::class);

        Route::get(uri:'products/{product}/variants', action: [ProductVariantController::class, 'getProductVariants'])->name(name: 'products.variants.index');
        Route::post(uri:'products/{product}/variants', action: [ProductVariantController::class, 'store'])->name(name: 'products.variants.store');
        Route::delete(uri:'product-variants/{id}', action: [ProductVariantController::class, 'destroy'])->name(name: 'products.variants.destroy');
    }

    private static function productImagesRoute(): void
    {
        Route::post(uri: 'products/images/{product}/upload-image', action: [ProductImageController::class, 'uploadImage'])->name(name: 'products.images.upload');
        Route::post(uri: 'products/images/{product}/reorder', action: [ProductImageController::class, 'reorderImages'])->name(name: 'products.images.reorder');
    }

    /**
     * @return void
     */
    private static function unitsRoute(): void
    {
        Route::get(uri: 'units/list', action: [UnitController::class, 'list'])->name(name: 'units.list');
        Route::resource(name: 'units', controller: UnitController::class);
    }

    /**
     * @return void
     */
    private static function attributesRoute(): void
    {
        Route::get(uri: 'attributes/list', action: [AttributeController::class, 'list'])->name(name: 'attributes.list');
        Route::resource(name: 'attributes', controller: AttributeController::class);

        Route::get('attributes/{attribute}/options/list', [AttributeOptionController::class, 'list'])->name('attributes.options.list');
        Route::resource('attributes.options', AttributeOptionController::class);
    }

    private static function collectionsRoute(): void
    {
        Route::get(uri: 'collections/list', action: [CollectionController::class, 'list'])->name(name: 'collections.list');
        Route::resource(name: 'collections', controller: CollectionController::class);

        Route::get(uri: 'collections/{collection}/products/list', action: [CollectionProductController::class, 'list'])->name(name: 'collections.products.list');
        Route::get(uri: 'collections/{collection}/products', action: [CollectionProductController::class, 'index'])->name(name: 'collections.products.index');
        Route::post(uri: 'collections/{collection}/products', action: [CollectionProductController::class, 'store'])->name(name: 'collections.products.store');
        Route::delete(uri: 'collections/{collection}/products/{product}', action: [CollectionProductController::class, 'destroy'])->name(name: 'collections.products.destroy');
    }
}
