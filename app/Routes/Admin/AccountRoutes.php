<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Accounts\AdminController,
    Http\Controllers\Admin\Accounts\ClientController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class AccountRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        self::usersRoutes();
        self::clientsRoutes();
    }

    /**
     * @return void
     */
    private static function usersRoutes(): void
    {
        Route::get(uri: 'admins/list', action: [AdminController::class, 'list'])->name(name: 'admins.list');
        Route::resource(name: 'admins', controller: AdminController::class);
    }

    /**
     * @return void
     */
    private static function clientsRoutes(): void
    {
        Route::get(uri: 'clients/select', action: [ClientController::class, 'select'])->name(name: 'clients.select');
        Route::get(uri: 'clients/list', action: [ClientController::class, 'list'])->name(name: 'clients.list');
        Route::post('clients/ajax-store', [ClientController::class, 'ajaxStore'])->name('clients.ajaxStore');
        Route::resource(name: 'clients', controller: ClientController::class);
    }
}
