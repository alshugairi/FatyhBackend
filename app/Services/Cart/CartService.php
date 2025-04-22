<?php

namespace App\Services\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Catalog\ProductRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService extends BaseService
{
    public function __construct(CartRepository $repository, private readonly ProductRepository $productRepository)
    {
        parent::__construct($repository);
    }

    private function getSessionId(): string
    {
        if (!Session::has('cart_session')) {
            Session::put('cart_session', Session::getId());
        }
        return Session::get('cart_session');
    }

    private function getUserCart()
    {
        return Auth::check()
            ? Cart::firstOrCreate(['user_id' => Auth::id()])
            : Cart::firstOrCreate(['session_id' => $this->getSessionId()]);
    }

    public function getCurrentCart(): ?Cart
    {
        return Auth::check()
            ? Cart::where('user_id', Auth::id())->with(['items','items.product','items.product.business'])->first()
            : Cart::where('session_id', $this->getSessionId())->with(['items','items.product','items.product.business'])->first();
    }

    public function getCart($paginate = 24)
    {
        $cart = $this->getUserCart();

        return $this->productRepository->newQuery()
            ->join('cart_items', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.cart_id', $cart->id)
            ->select('products.*')
            ->with(['images'])
            ->paginate($paginate);
    }

    public function addToCart(int $productId, int $quantity = 1): ?Cart
    {
        $cart = $this->getUserCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'quantity'   => $quantity,
                'price'      => $this->productRepository->find($productId)->sell_price,
            ]);
        }

        return $cart;
    }

    public function removeFromCart(int $productId): bool
    {
        $cart = $this->getUserCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            throw new \Exception(__('share.not_found'));
        }

        $cartItem->delete();

        if ($cart->items()->count() === 0) {
            $cart->delete();
        }

        return true;
    }
}
