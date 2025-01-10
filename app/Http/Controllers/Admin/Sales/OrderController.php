<?php

namespace App\Http\Controllers\Admin\Sales;

use App\{Enums\PlatformType,
    Http\Controllers\Controller,
    Http\Requests\Admin\Sales\OrderRequest,
    Models\Order,
    Pipelines\Catalog\OrderFilterPipeline,
    Pipelines\Settings\SettingsFilterPipeline,
    Services\Sales\OrderService,
    Services\Settings\SettingsService,
    Utils\HttpFoundation\Response};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param OrderService $service
     */
    public function __construct(private readonly OrderService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.sales.orders.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.sales.orders.create', get_defined_vars());
    }

    /**
     * @param OrderRequest $request
     * @return Response
     */
    public function store(OrderRequest $request): Response
    {
        $order = $this->service->create(data: array_merge($request->validated(), ['creator_id' => auth()->id(), 'platform' => PlatformType::Pos]));
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ['order_id' => $order->id],
        );
    }

    public function invoice(Order $order)
    {
        $settings = app(SettingsService::class)->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'company']))]);
        return view('admin.modules.sales.orders.invoice', get_defined_vars());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list(filters: [
            new OrderFilterPipeline(request: $request),
        ], relations: ['user']);
    }
}
