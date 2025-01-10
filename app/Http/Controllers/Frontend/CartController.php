<?php

namespace App\Http\Controllers\Frontend;

use Darryldecode\Cart\Cart;
use App\{Enums\UserType, Http\Controllers\Controller, Models\Product, Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\Request, Support\Facades\DB};

class CartController extends Controller
{
    public function index(): View
    {
        $cartItems = \Cart::getContent();
        $cartTotal = \Cart::getTotal();

        return view('frontend.modules.cart', get_defined_vars());
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);

        if ($product) {
            \Cart::add([
                'id' => $request->id,
                'name' => $product->name,
                'price' => $product->sell_price,
                'quantity' => $request->quantity,
                'attributes' => [
                    'image' => get_full_image_url($product->image)
                ]
            ]);

            return Response::response(
                message: __('frontend.product_added_to_cart'),
                data: $this->cartSummary()
            );
        }
    }

    public function removeFromCart($id): Response
    {
        \Cart::remove($id);

        return Response::response(
            message: __('frontend.item_removed_from_cart'),
            data: $this->cartSummary()
        );
    }

    public function updateCart(Request $request, $id): Response
    {
        \Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ]
        ]);
        $cartItem = \Cart::get($id);
        $productTotal = $cartItem->quantity * $cartItem->price;

        return Response::response(
            message:  __('frontend.cart_updated'),
            data: array_merge($this->cartSummary(), [
                'formatted_price' => format_currency((float)$productTotal)
            ])
        );
    }

    public function cartSummary(): array
    {
        return [
            'cart_count' => (\Cart::getContent())->count(),
            'cart_amount' => \Cart::getTotal()
        ];
    }

    public function clearCart(): Response
    {
        \Cart::clear();

        return Response::response(
            message: 'Cart cleared'
        );
    }
}
