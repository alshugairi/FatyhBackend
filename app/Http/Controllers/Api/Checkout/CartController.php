<?php

namespace App\Http\Controllers\Api\Checkout;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\CartRequest,
    Http\Requests\Api\DeleteFromCartRequest,
    Http\Resources\CartResource,
    Services\Cart\CartService,
    Utils\HttpFoundation\Response};
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService)
    {
    }

    public function index()
    {
        $cart = $this->cartService->getCurrentCart();

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new CartResource($cart),
        );
    }

    public function store(CartRequest $request): Response
    {
        $this->cartService->addToCart(productId: $request->product_id, quantity: $request->quantity);

        return Response::response(
            message: __('share.added_successfully'),
        );
    }

    public function removeFromCart(DeleteFromCartRequest $request): Response
    {
        $this->cartService->removeFromCart($request->product_id);

        return Response::response(
            message: __('share.removed_successfully')
        );
    }

    public function getSessionId(): string
    {
        $sessionId = request()->header('X-Session-Id');

        if (!$sessionId) {
            if (!Session::has('cart_session')) {
                Session::put('cart_session', Session::getId());
            }
            $sessionId = Session::get('cart_session');
        }

        return $sessionId;
    }
}
