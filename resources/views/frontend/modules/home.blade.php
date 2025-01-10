@extends('frontend.layouts.app')

@section('content')
    @if(count($sliders) > 0)
        <div class="slider-wrapper position-relative">
            <div class="loading-overlay">
                <div class="spinner"></div>
            </div>
            <div class="slider w-100" data-slick='{"slidesToShow": 1, "slidesToScroll": 1}' style="opacity: 0;">
                @foreach($sliders as $slider)
                    <div class="slider-item">
                        <img src="{{ get_full_image_url($slider->image) }}" alt="Slider Image">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="wide-container  ">
        <section class="categories-section d-none">
            <div class="section-title my-3">
                <h2>Categories</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-6">
                    <div class="category-item">
                        <div class="category-wrapper">
                            <div class="category-image">
                                <img src="https://woodmart.b-cdn.net/furniture2/wp-content/uploads/sites/11/2023/04/wd-furniture-category-chairs.jpg.webp" alt="Chairs">
                            </div>
                            <div class="category-overlay">
                                <h3 class="category-name">Chairs<span class="category-count">(12)</span></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="wide-container">

        @foreach($collections as $index => $collection)
            <section class="mt-60 mb-60 rounded-25 border px-4 py-3 mb-60">
                <div class="section-title mb-3">
                    <h2 class="d-inline-block">{{ $collection->name }}</h2>
                    <a class="mx-2" href="{{ route('collection.index', $collection->id) }}">{{ __('frontend.see_all') }}</a>
                </div>
                <div class="slider-wrapper position-relative">
                    <div class="loading-overlay">
                        <div class="spinner"></div>
                    </div>
                    <div class="products-slider product-grid floating-controls" data-slick='{"slidesToShow": 6, "slidesToScroll": 6}' style="opacity: 0;">
                        @foreach($collection->collectionProducts as $collectionProduct)
                            @include('frontend.partial.products.product_card', ['product' => $collectionProduct->product])
                        @endforeach
                    </div>
                </div>
            </section>
        @endforeach

    <div class="mt-60 mb-60 text-center">
        <a href="">
            <img class="img-fluid" src="{{ asset('assets/frontend') }}/images/banner1.png">
        </a>
    </div>

    @if($newArrivalProducts->isNotEmpty())
    <section class="mt-60 mb-60">
        <div class="section-title my-3">
            <h2>{{ __('frontend.new_arrivals') }}</h2>
        </div>
        <div class="product-grid">
            <div class="row">
                @foreach($newArrivalProducts as $newArrivalProduct)
                    <div class="col-md-2 p-0">
                        @include('frontend.partial.products.product_card', ['product' => $newArrivalProduct])
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if(count(get_brands()) > 0)
            <section class="mt-60 mb-60">
                <div class="slider-wrapper position-relative">
                    <div class="loading-overlay">
                        <div class="spinner"></div>
                    </div>
                    <div class="slider-5 w-100 border-bottom border-top py-4" data-slick='{"slidesToShow": 5, "slidesToScroll": 5}' style="opacity: 0;">
                        @foreach(get_brands() as $brand)
                        <a href="{{ route('products.index', ['brand' => $brand->id]) }}" class="slider-5-item">
                            <img class="img-fluid" src="{{ get_full_image_url($brand->image) }}" alt="{{ $brand->name }}">
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
</div>
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend') }}/plugins/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend') }}/plugins/slick/slick-theme.css"/>
@endpush

@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/frontend') }}/plugins/slick/slick.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.slider, .products-slider, .slider-5').each(function() {
                const $slider = $(this);

                const slickOptions = $slider.data('slick') || {};

                Object.assign(slickOptions, {
                    dots: false,
                    infinite: true,
                    speed: 1000,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    arrows: true
                });

                $slider.on('init', function() {
                    $slider.closest('.slider-wrapper').find('.loading-overlay').fadeOut();
                    $slider.css('opacity', 1);
                });

                $slider.slick(slickOptions);
            });
        });

    </script>
@endpush
