@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ __('frontend.cart') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        <div class="row cart-items" @if(!$cartItems->count() > 0) style="display: none" @endif>
            <div class="col-lg-8">
                @foreach($cartItems as $item)
                    @php($product = \App\Models\Product::find($item->id))
                    <div class="cart-item" data-id="{{ $item->id }}">
                        <div class="row align-items-center1">
                            <div class="col-2">
                                <img src="{{ $item->attributes->image }}" alt="{{ $item->name }}" class="product-image">
                            </div>
                            <div class="col-4 position-relative">
                                <h5 class="mb-2">{{ $product->name }}</h5>
                                <div class="product-details mb-2">
                                    <span class="me-3">Black</span>
                                    <span>2XL</span>
                                </div>
                                <span class="stock-status in-stock mb-2">{{ __('frontend.in_stock') }}</span>
                            </div>
                            <div class="col-3">
                                <div class="quantity-control">
                                    <button class="decrease">−</button>
                                    <input type="text" value="{{ $item->quantity }}" readonly>
                                    <button class="increase">+</button>
                                </div>
                            </div>
                            <div class="col-2">
                                <span class="price">{{ format_currency((float)($item->quantity * $item->price)) }}</span>
                            </div>
                            <div class="col-1">
                                <a href="#" class="remove-link remove-from-cart">{{ __('frontend.remove') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-4">
                <div class="order-summary">
                    <h5 class="mb-4">{{ __('frontend.order_summary') }}</h5>
                    <div class="summary-row">
                        <span>{{ __('frontend.subtotal') }}</span>
                        <span class="order_subtotal">{{ $cartTotal }}</span>
                    </div>
                    <div class="summary-row">
                        <span>{{ __('frontend.shipping_cost') }}</span>
                        <span>0</span>
                    </div>
                    <div class="summary-row">
                        <span>{{ __('frontend.tax') }}</span>
                        <span>0</span>
                    </div>
                    <div class="summary-row border-top pt-3">
                        <strong>{{ __('frontend.order_total') }}</strong>
                        <strong class="order_total">{{ $cartTotal }}</strong>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="btn btn-dark mt-4 d-block">{{ __('frontend.checkout') }}</a>
                </div>
            </div>
        </div>
        <div class="text-center mt-100 mb-100 empty-cart" @if($cartItems->count() > 0) style="display: none" @endif >
            <div class="my-4">
                <i class="fa-solid fa-basket-shopping fz-110"></i>
            </div>
            <h4 class="fw-600">{{ __('frontend.empty_cart') }}</h4>
        </div>
    </div>
@endsection
