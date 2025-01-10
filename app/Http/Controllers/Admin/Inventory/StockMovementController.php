<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\{Http\Controllers\Controller,
    Pipelines\Inventory\StockMovementFilterPipeline,
    Services\Inventory\StockMovementService};
use Illuminate\{Contracts\View\View, Http\JsonResponse};
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function __construct(private readonly StockMovementService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.inventory.stock_movements', get_defined_vars());
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [
            new StockMovementFilterPipeline(request: $request),
        ]);
    }
}
