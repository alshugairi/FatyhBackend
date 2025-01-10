<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\{Http\Controllers\Controller,
    Models\Product,
    Services\Inventory\InventoryService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Support\Facades\DB};
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class InventoryController extends Controller
{
    public function __construct(private readonly InventoryService $service)
    {
    }

    public function index(): View
    {
        return view('admin.modules.inventory.inventory');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
