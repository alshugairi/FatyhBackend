<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Sales\CouponController,
    Http\Controllers\Admin\Sales\TaxController,
    Http\Controllers\Admin\Sales\PosController,
    Http\Controllers\Admin\Sales\OrderController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class SalesRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        self::couponsRoutes();
        self::taxesRoutes();
        self::ordersRoutes();
        self::posRoutes();
    }

    private static function couponsRoutes(): void
    {
        Route::get(uri: '/coupons/list', action: [CouponController::class, 'list'])->name(name: 'coupons.list');
        Route::resource(name: 'coupons', controller: CouponController::class);
    }

    private static function taxesRoutes(): void
    {
        Route::get(uri: '/taxes/list', action: [TaxController::class, 'list'])->name(name: 'taxes.list');
        Route::resource(name: 'taxes', controller: TaxController::class);
    }

    private static function ordersRoutes(): void
    {
        Route::get(uri: 'orders/invoice/{order}', action: [OrderController::class, 'invoice'])->name(name: 'orders.invoice');
        Route::get(uri: 'orders/list', action: [OrderController::class, 'list'])->name(name: 'orders.list');
        Route::resource(name: 'orders', controller: OrderController::class);
    }

    private static function posRoutes(): void
    {
        Route::get(uri: 'pos', action: [PosController::class, 'index'])->name(name: 'pos.index');
    }
}
