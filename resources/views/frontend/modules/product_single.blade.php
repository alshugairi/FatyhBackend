@extends('frontend.layouts.app')
@include('frontend.partial.products.product-seo')
@section('content')
<div class="wide-container mt-3">
    <div class="row">
        <div class="col-md-9">
            @include('flash::message')
            <div class="row">
                <div class="col-md-6">
                    <div class="image-column">
                        <div class="product-thumbs me-3">
                            @if($product->images->isNotEmpty())
                                @foreach($product->images as $image)
                                    <img src="{{ get_full_image_url($image->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="mb-2 thumbnail"
                                         data-full-img="{{ get_full_image_url($image->image_path) }}">
                                @endforeach
                            @else
                                <img src="{{ get_default_image() }}"
                                     alt="{{ $product->name }}"
                                     class="mb-2 thumbnail"
                                     data-full-img="{{ get_default_image() }}">
                            @endif
                        </div>
                        <div class="main-image-container">
                            @php($mainImage = $product->images->first())
                            <div class="zoom-wrapper">
                                @if($mainImage)
                                    <img src="{{ get_full_image_url($mainImage->image_path) }}"
                                         data-zoom="{{ get_full_image_url($mainImage->image_path) }}"
                                         alt="{{ $product->name }}"
                                         class="main-image"
                                         id="mainImage">
                                @else
                                    <img src="{{ get_default_image() }}"
                                         data-zoom="{{ get_default_image() }}"
                                         alt="{{ $product->name }}"
                                         class="main-image"
                                         id="mainImage">
                                @endif
                                <div class="zoom-result"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Sale Banner -->
                    <div class="mb-3">
                        <span class="sale-tag">SALE</span>
                    </div>
                    <div class="mb-3">
                        <div class="h3 mb-0">{{ format_currency($product->sell_price) }}</div>
                        <div>
                            <span class="text-decoration-line-through text-muted">EGP901.29</span>
                            <span class="text-danger ms-2">40% off</span>
                        </div>
                    </div>
                    <h1 class="h5 mb-3">{{ $product->name }}</h1>
                    <h1 class="h6 mb-3">{!! $product->description !!}</h1>
                    <div class="mb-4">
                        <div class="text-warning">
                            {!! render_stars($product->rating) !!}
                            <span class="text-dark ms-2">{{ $product->rating }}</span>
                        </div>
                        <span class="text-muted">{{ $product->reviewsCount() }} {{ __('frontend.reviews') }} | {{ $product->sold_count }} {{ __('frontend.sold') }}</span>
                    </div>

                    @if($product->has_variants)
                        <div class="variants-section">
                            @foreach($attributes as $attributeName => $options)
                                <div class="mb-3">
                                    <div class="fw-bold mb-2">{{ $attributeName }}: <span class="selected-{{ Str::slug($attributeName) }}"></span></div>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($options->unique('id') as $option)
                                            <?php
                                                $variant = $product->variants->first(function($v) use($option) {
                                                    return $v->attributeOptions->contains('id', $option->id);
                                                });
                                                $isAvailable = optional($variant)->stock_quantity > 0 && optional($variant)->is_active;
                                            ?>

                                            @if(strtolower($attributeName) === 'color')
                                                <div class="variant-option color-option {{ !$isAvailable ? 'disabled' : '' }}"
                                                     data-attribute-id="{{ $option->attribute_id }}"
                                                     data-option-id="{{ $option->id }}"
                                                     data-value="{{ $option->value }}"
                                                     style="background-color: {{ $option->value }};"
                                                     title="{{ $option->name }}">
                                                    @if($variant && $variant->image)
                                                        <img src="{{ get_full_image_url($variant->image) }}"
                                                             alt="{{ $option->name }}"
                                                             class="variant-image">
                                                    @endif
                                                </div>
                                            @else
                                                <button class="variant-option size-btn {{ !$isAvailable ? 'disabled' : '' }}"
                                                        data-attribute-id="{{ $option->attribute_id }}"
                                                        data-option-id="{{ $option->id }}"
                                                        data-value="{{ $option->value }}"
                                                    {{ !$isAvailable ? 'disabled' : '' }}>
                                                    {{ $option->name }}
                                                </button>
                                            @endif
                                        @endforeach
                                    </div>
                                    @if($variant)
{{--                                        <div class="text-muted mt-2">--}}
{{--                                            Stock: <span class="variant-stock">{{ $variant->stock_quantity }}</span>--}}
{{--                                        </div>--}}
                                    @endif
                                </div>
                            @endforeach

                            <input type="hidden" name="selected_variant_id" id="selected_variant_id">
                            <input type="hidden" name="selected_options" id="selected_options" value="{}">
                        </div>
                    @endif
                </div>

                <div class="col-md-12">
                    <nav class="nav mb-4">
                        <a class="nav-link active" href="#">Customer Reviews (15)</a>
                        <a class="nav-link" href="#">Specifications</a>
                    </nav>

                    <div id="customer-reviews">

                        <div class="row mb-5">
                            <div class="col-md-4">
                                <div class="rating-number">{{ $product->rating }}</div>
                                <div class="rating-stars mb-2">
                                    {!! render_stars($product->rating) !!}
                                </div>
                                <div class="verified-text"></div>
                            </div>
                            <div class="col-md-8">
                                <div class="rating-breakdown">
                                    @foreach(range(5, 1) as $stars)
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rating-stars me-2">{!! render_stars($stars) !!}</div>
                                            <div class="progress flex-grow-1">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $ratingPercentages[$stars] ?? 0 }}%"></div>
                                            </div>
                                            <span class="ms-2">{{ $ratingBreakdown[$stars] ?? 0 }}</span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <div class="border rounded-3 p-3 mb-5">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="mb-3">
                                    <label for="rating" class="form-label">{{ __('frontend.rating') }}</label>
                                    <select name="rating" id="rating" class="form-control" required>
                                        <option value="1">1 {{ __('frontend.star') }}</option>
                                        <option value="2">2 {{ __('frontend.stars') }}</option>
                                        <option value="3">3 {{ __('frontend.stars') }}</option>
                                        <option value="4">4 {{ __('frontend.stars') }}</option>
                                        <option value="5">5 {{ __('frontend.stars') }}</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="review" class="form-label">{{ __('frontend.review') }}</label>
                                    <textarea name="review" id="review" class="form-control" rows="4"></textarea>
                                </div>

                                <button type="submit" class="btn btn-dark">{{ __('frontend.submit_review') }}</button>
                            </form>
                        </div>

                        <div class="reviews-list">
                            <div class="row">
                                @foreach($reviews as $review)
                                <div class="col-md-6">
                                    <div class="review-item mb-3 border rounded-3 p-3">
                                        <div class="d-flex">
                                            <div class="profile-image me-3">
                                                {{ strtoupper(substr($review->user?->name, 0, 1)) . strtoupper(substr(strrchr($review->user?->name, ' '), 1, 1)) }}
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <h6 class="mb-0 fw-600">{{ $review->user?->name }}</h6>
                                                </div>
                                                <div class="rating-stars mb-2">{!! render_stars($review->rating) !!}</div>
                                                <p class="review-text mb-2">{{ $review->review }}</p>
                                                <p class="review-date mb-0">{{ $review->formatted_created_at }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">

                    <div class="mb-4">
                        <div class="fw-bold mb-2">Quantity</div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-outline-secondary">-</button>
                            <input type="number" class="form-control quantity-input" value="1">
                            <button class="btn btn-outline-secondary">+</button>
                            <span class="ms-3 text-muted">91 available</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <form action="{{ route('compare.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="btn btn-info w-100">Add to Compare</button>
                        </form>
                        <button class="btn btn-danger">Buy now</button>
                        <button class="btn btn-outline-secondary">Add to cart</button>
                    </div>

                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-link text-dark">
                            <i class="fas fa-share-alt"></i> Share
                        </button>
                        <button class="btn btn-link text-dark">
                            <i class="far fa-heart"></i> {{ $product->wishlistCount() }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($relatedProducts->isNotEmpty())
        <section class="mt-60 mb-60">
            <div class="section-title my-3">
                <h2>{{ __('frontend.related_products') }}</h2>
            </div>
            <div class="product-grid">
                <div class="row">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="col-md-2 p-0">
                            @include('frontend.partial.products.product_card', ['product' => $relatedProduct])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
    <script>
        function changeImage(element) {
            document.getElementById('mainImage').src = element.src;
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            element.classList.add('active');
        }

        function setRating(rating) {
            const stars = document.querySelectorAll('.review-form .star-rating i');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        }

        $(document).ready(function() {
            $('.product-thumbs img:first').addClass('active');

            $('.product-thumbs img').click(function() {
                const fullImg = $(this).data('full-img');
                const $mainImage = $('#mainImage');

                $mainImage.attr('src', fullImg);
                $mainImage.attr('data-zoom', fullImg);

                $('.product-thumbs img').removeClass('active');
                $(this).addClass('active');
            });

            initZoom();

            function initZoom() {
                const $mainImage = $('#mainImage');
                const $zoomResult = $('.zoom-result');
                let isZooming = false;

                $mainImage.on('mouseenter', function() {
                    if (!isZooming) {
                        const zoomImage = new Image();
                        zoomImage.src = $(this).attr('data-zoom');

                        zoomImage.onload = function() {
                            isZooming = true;
                            $zoomResult.show();
                        }
                    } else {
                        $zoomResult.show();
                    }
                });

                $mainImage.on('mouseleave', function() {
                    $zoomResult.hide();
                });

                $mainImage.on('mousemove', function(e) {
                    if (!isZooming) return;

                    const $this = $(this);
                    const offset = $this.offset();
                    const width = $this.width();
                    const height = $this.height();

                    let mouseX = e.pageX - offset.left;
                    let mouseY = e.pageY - offset.top;

                    const percentX = (mouseX / width) * 100;
                    const percentY = (mouseY / height) * 100;

                    mouseX = Math.min(Math.max(mouseX, 0), width);
                    mouseY = Math.min(Math.max(mouseY, 0), height);

                    $zoomResult.css({
                        backgroundImage: `url(${$this.attr('data-zoom')})`,
                        backgroundPosition: `${percentX}% ${percentY}%`,
                        backgroundSize: '250%'
                    });
                });
            }
        });
    </script>
@endpush

