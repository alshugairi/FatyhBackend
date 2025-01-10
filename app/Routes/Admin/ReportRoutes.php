<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Reports\UserReportController,
    Http\Controllers\Admin\Reports\ProductReportController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class ReportRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        self::userReportRoutes();
        self::productReportRoutes();
    }

    private static function userReportRoutes(): void
    {
        Route::get(uri: 'reports/credit-balance/list', action: [UserReportController::class, 'creditBalanceList'])->name(name: 'reports.creditBalanceList');
        Route::get(uri: 'reports/credit-balance', action: [UserReportController::class, 'creditBalance'])->name(name: 'reports.creditBalance');
    }

    private static function productReportRoutes(): void
    {
        Route::get(uri: 'reports/products/list', action: [ProductReportController::class, 'productsList'])->name(name: 'reports.productsList');
        Route::get(uri: 'reports/products', action: [ProductReportController::class, 'products'])->name(name: 'reports.products');
    }
}
