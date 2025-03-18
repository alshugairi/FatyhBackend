<?php

namespace App\Http\Controllers\Api\Checkout;

use App\{Enums\PlatformType,
    Http\Controllers\Controller,
    Http\Requests\Api\OrderRequest,
    Http\Resources\OrderResource,
    Models\Order,
    Pipelines\Catalog\OrderFilterPipeline,
    Pipelines\Settings\SettingsFilterPipeline,
    Services\Cart\CartService,
    Services\Sales\OrderService,
    Services\Settings\SettingsService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse};
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService,
                                private readonly CartService $cartService)
    {
    }

    public function store(OrderRequest $request): Response
    {
        $cart = $this->cartService->getCurrentCart();

        if (!$cart || $cart->items->isEmpty()) {
            return Response::error(
                message: __('share.empty_cart'),
                status: HttpStatus::HTTP_BAD_REQUEST
            );
        }

        $orderData = array_merge($request->validated(), [
            'user_id' => auth()->id(),
            'platform' => PlatformType::Web,
            'items' => $cart->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            })->toArray()
        ]);

        $order = $this->orderService->create($orderData);

        $cart->items()->delete();
        $cart->delete();

        return Response::response(
            message: __('share.request_successfully'),
            data: [
                'order_id' => $order->id,
                'order_number' => $order->number,
                'redirect_url' => '/invoice/'. $order->id
            ]
        );
    }

    public function show(int $orderId)
    {
        $order = $this->orderService->find($orderId);

        if (!$order) {
            return Response::error(
                message: __('share.order_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND
            );
        }

        return Response::response(
            message: __('share.request_successfully'),
            data: new OrderResource($order)
        );
    }
}
