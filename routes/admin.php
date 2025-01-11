<?php

use App\{Http\Controllers\Admin\AuthController,
    Routes\Admin\AccountRoutes,
    Routes\Admin\SalesRoutes,
    Routes\Admin\SettingsRoutes,
    Routes\Admin\CatalogRoutes,
    Routes\Admin\InventoryRoutes,
    Routes\Admin\ReportRoutes,
    Routes\Admin\FinanceRoutes,
    Http\Controllers\Admin\DashboardController,
    Http\Controllers\Admin\ContactController};
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'backend/admin', 'as' => 'admin.'], function () {

    Route::get(uri: 'login', action: [AuthController::class, 'login'])->name('login');
    Route::post(uri: 'login', action: [AuthController::class, 'authenticate'])->name('authenticate');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::group(attributes: ['middleware' => ['auth','EnsureIsAdmin']], routes: static function () {
        Route::get(uri: 'dashboard', action: [DashboardController::class, 'index'])->name('dashboard');
        Route::post(uri: 'dashboard', action: [DashboardController::class, 'loadData'])->name('dashboard.loadData');

        Route::get(uri: 'contact/list', action: [ContactController::class, 'list'])->name(name: 'contact.list');
        Route::resource(name: 'contact', controller: ContactController::class);

        AccountRoutes::registerRoutes();
        SalesRoutes::registerRoutes();
        SettingsRoutes::registerRoutes();
        CatalogRoutes::registerRoutes();
        InventoryRoutes::registerRoutes();
        ReportRoutes::registerRoutes();
        FinanceRoutes::registerRoutes();
    });
});
