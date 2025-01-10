<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\DashboardController;
use App\Http\Controllers\Account\OrderController;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Account\AddressController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function()
{
    Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
        Route::get(uri: 'overview', action: [DashboardController::class, 'index'])->name(name: 'dashboard');
        Route::get(uri: 'orders', action: [OrderController::class, 'index'])->name(name: 'orders.index');
        Route::get(uri: 'return-orders', action: [OrderController::class, 'returnOrders'])->name(name: 'orders.return');
        Route::get(uri: 'orders/{order}', action: [OrderController::class, 'show'])->name(name: 'orders.show');
        Route::get(uri: 'orders/invoice/{order}', action: [OrderController::class, 'invoice'])->name(name: 'orders.invoice');
        Route::get(uri: 'info', action: [AccountController::class, 'info'])->name(name: 'info');
        Route::post(uri: 'info', action: [AccountController::class, 'updateInfo'])->name(name: 'info.update');
        Route::get(uri: 'change-password', action: [AccountController::class, 'changePassword'])->name(name: 'change_password');
        Route::post(uri: 'change-password', action: [AccountController::class, 'updatePassword'])->name(name: 'password.update');
        Route::resource(name: 'address', controller: AddressController::class);
    });
});

