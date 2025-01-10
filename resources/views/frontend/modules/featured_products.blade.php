@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ __('frontend.featured_products') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        <div class="product-grid">
            <div class="row">
                @if($products->isEmpty())
                    <div class="text-center mt-100 mb-100">
                        <div class="my-4">
                            <i class="fas fa-box-open fz-110"></i>
                        </div>
                        <h4 class="fw-600">{{ __('frontend.no_products_found') }}</h4>
                    </div>
                @else
                    @foreach($products as $product)
                        <div class="col-md-2 p-0">
                            @include('frontend.partial.products.product_card')
                        </div>
                    @endforeach
                @endif
            </div>
            @if($products->isNotEmpty())
                {{ $products->links('pagination::bootstrap-5') }}
            @endif
        </div>
    </div>
@endsection
