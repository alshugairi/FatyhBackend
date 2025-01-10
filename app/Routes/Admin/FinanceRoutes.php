<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Finance\TransactionController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class FinanceRoutes implements RoutesInterface
{
    public static function registerRoutes(): void
    {
        self::transactionsRoutes();
    }

    private static function transactionsRoutes(): void
    {
        Route::get(uri: 'transactions/list', action: [TransactionController::class, 'list'])->name(name: 'transactions.list');
        Route::resource(name: 'transactions', controller: TransactionController::class);
    }
}
