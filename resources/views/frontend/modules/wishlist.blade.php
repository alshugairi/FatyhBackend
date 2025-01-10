@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ __('frontend.wishlist') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        <div class="product-grid wishlist-items" @if($wishlists->isEmpty()) style="display: none" @endif>
            <div class="row">
                    @foreach($wishlists as $wishlist)
                        @php($product = $wishlist->product)
                        @php($product->is_wishlist = 1)
                        <div class="col-md-2 p-0">
                            @include('frontend.partial.products.product_card', ['pageName' => 'wishlist'])
                        </div>
                    @endforeach
            </div>
            @if($wishlists->isNotEmpty())
                {{ $wishlists->links('pagination::bootstrap-5') }}
            @endif
        </div>
        <div class="text-center mt-100 mb-100 empty-wishlist" @if($wishlists->isNotEmpty()) style="display: none" @endif >
            <div class="my-4">
                <i class="fa-regular fa-heart fz-110"></i>
            </div>
            <h4 class="fw-600">{{ __('frontend.empty_wishlist') }}</h4>
        </div>
    </div>
@endsection
