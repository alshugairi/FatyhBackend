<?php

namespace App\Routes\Admin;

use App\{Http\Controllers\Admin\Inventory\SupplierController,
    Http\Controllers\Admin\Inventory\PurchaseController,
    Http\Controllers\Admin\Inventory\StockMovementController,
    Http\Controllers\Admin\Inventory\InventoryController,
    Routes\Interfaces\RoutesInterface};
use Illuminate\Support\Facades\Route;

class InventoryRoutes implements RoutesInterface
{
    /**
     * @return void
     */
    public static function registerRoutes(): void
    {
        self::inventoryRoutes();
        self::suppliersRoutes();
        self::purchasesRoutes();
        self::stockRoutes();
    }

    private static function inventoryRoutes(): void
    {
        Route::get(uri: 'inventory/list', action: [InventoryController::class, 'list'])->name(name: 'inventory.list');
        Route::get(uri: 'inventory', action: [InventoryController::class, 'index'])->name(name: 'inventory.index');
    }

    private static function suppliersRoutes(): void
    {
        Route::get(uri: 'suppliers/list', action: [SupplierController::class, 'list'])->name(name: 'suppliers.list');
        Route::resource(name: 'suppliers', controller: SupplierController::class);
    }

    private static function purchasesRoutes(): void
    {
        Route::get(uri: 'purchases/list', action: [PurchaseController::class, 'list'])->name(name: 'purchases.list');
        Route::resource(name: 'purchases', controller: PurchaseController::class);
    }

    private static function stockRoutes(): void
    {
        Route::get(uri: 'stock-movements/list', action: [StockMovementController::class, 'list'])->name(name: 'stock_movements.list');
        Route::resource(name: 'stock-movements', controller: StockMovementController::class)->names(names: 'stock_movements');
    }
}
