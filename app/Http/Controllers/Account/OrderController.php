<?php

namespace App\Http\Controllers\Account;

use App\{Enums\OrderStatus,
    Enums\UserType,
    Http\Controllers\Controller,
    Models\Order,
    Pipelines\Catalog\OrderFilterPipeline,
    Pipelines\Settings\SettingsFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Sales\OrderService,
    Services\Settings\SettingsService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\Request, Support\Facades\DB};

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $service)
    {
    }

    public function index(): View
    {
        $orders = $this->service->index(filters: [
                        new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
                        new OrderFilterPipeline(request: new Request(['user_id' => auth()->id()])),
                    ], withCount: ['items']);

        return view('account.modules.orders.index', get_defined_vars());
    }

    public function returnOrders(): View
    {
        $orders = $this->service->index(filters: [
            new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc'),
            new OrderFilterPipeline(request: new Request(['user_id' => auth()->id(), 'status_in' =>
                [
                    OrderStatus::RETURNED->value,
                    OrderStatus::REFUND_REQUESTED->value,
                    OrderStatus::REFUNDED->value,
                ]
            ])),
        ], withCount: ['items']);

        return view('account.modules.orders.return_orders', get_defined_vars());
    }

    public function show(Order $order): View
    {
        return view('account.modules.orders.show', get_defined_vars());
    }

    public function invoice(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            return __('frontend.error');
        }
        $settings = app(SettingsService::class)->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'company']))]);
        return view('account.modules.orders.invoice', get_defined_vars());
    }
}
