@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ __('frontend.compare') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-60 mb-60">
        @include('flash::message')

        @if($products->isEmpty())
            <div class="text-center mt-100 mb-100">
                <div class="my-4">
                    <i class="fas fa-box-open fz-110"></i>
                </div>
                <h4 class="fw-600">{{ __('frontend.empty_comparison') }}</h4>
            </div>
        @else
            <div class="table-responsive">
            <table class="table table-bordered compare__table">
                <tbody>
                <!-- Product Row -->
                <tr class="text-center">
                    <th scope="row" class="bg-light">Product</th>
                    @foreach ($products as $comparison)
                        @php($product = $comparison->product)
                    <td>
                        <div class="compare__product-container">
                            <form action="{{ route('compare.remove') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="product_id" value="{{ $comparison->product_id }}">
                                <button type="submit" class="compare__remove-btn">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </form>
                            <div class="compare__product-image">
                                <img src="{{ get_full_image_url($product->image) }}" alt="Product 1" class="img-fluid rounded">
                            </div>
                            <a href="#" class="compare__product-title">{{ $product->name }}</a>
                            <div class="compare__product-price">{{ format_currency($product->sell_price) }}</div>
                            <button class="compare__btn-cart">Add to Cart</button>
                            <div class="compare__stock-status">
                                <i class="fas fa-check compare__in-stock"></i> In stock
                            </div>
                        </div>
                    </td>
                    @endforeach
                </tr>

                <!-- Description Row -->
                <tr>
                    <th scope="row">Description</th>
                    @foreach ($products as $comparison)
                    <td>
                        <p class="compare__description">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, vitae doloremque voluptatum doloribus neque assumenda velit.</p>
                    </td>
                    @endforeach
                </tr>

                <!-- Availability Row -->
                <tr>
                    <th scope="row">Availability</th>
                    @foreach ($products as $comparison)
                    <td class="text-center compare__specs">
                            <span class="compare__stock-status">
                                <i class="fas fa-check compare__in-stock"></i> In stock
                            </span>
                    </td>
                    @endforeach
                </tr>

                <!-- Weight Row -->
                <tr>
                    <th scope="row">Weight</th>
                    @foreach ($products as $comparison)
                    <td class="text-center compare__specs">2.5 kg</td>
                    @endforeach
                </tr>

                <!-- Dimensions Row -->
                <tr>
                    <th scope="row">Dimensions</th>
                    @foreach ($products as $comparison)
                    <td class="text-center compare__specs">90 x 60 x 90 cm</td>
                    @endforeach
                </tr>

                <!-- Brand Row -->
                <tr>
                    <th scope="row">Brand</th>
                    @foreach ($products as $comparison)
                    <td class="text-center compare__specs">Apple</td>
                    @endforeach
                </tr>

                <!-- Color Row -->
                <tr>
                    <th scope="row">Color</th>
                    @foreach ($products as $comparison)
                    <td class="text-center compare__specs">Black, Blue, Grey</td>
                    @endforeach
                </tr>
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection
