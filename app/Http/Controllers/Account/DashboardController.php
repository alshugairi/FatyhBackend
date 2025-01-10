<?php

namespace App\Http\Controllers\Account;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Models\Order,
    Pipelines\Catalog\OrderFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Sales\OrderService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\Request, Support\Facades\DB};

class DashboardController extends Controller
{
    public function __construct(private readonly OrderService $orderService)
    {
    }

    public function index(): View
    {
        $orderCounts = Order::selectRaw('
                COUNT(*) as total_orders,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as delivered_orders,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as returned_orders',
                ['delivered', 'returned'])
            ->first();

        $orders = $this->orderService->getAll(filters: [
            new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
            new OrderFilterPipeline(request: new Request(['user_id' => auth()->id()])),
        ], relations: [], limit: 8, withCount: ['items']);

        return view('account.modules.dashboard', get_defined_vars());
    }
}
