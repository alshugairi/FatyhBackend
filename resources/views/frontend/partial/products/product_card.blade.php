<div class="product-card" data-id="{{ $product->id }}">
    <div class="product-image">
        <img src="{{ get_full_image_url($product->defaultImage?->image_path) }}" alt="{{ $product->name }}">
        <button class="float-add-to-cart add-to-cart" data-id="{{ $product->id }}">
            <i class="fa-solid fa-basket-shopping"></i>
        </button>
        <button class="floating-add-to-wishlist add-to-wishlist {{ $product->is_wishlist ? 'active' : '' }}"
                data-id="{{ $product->id }}" data-page="{{ $pageName ?? '' }}">
            <i class="fa-solid fa-heart"></i>
        </button>
    </div>
    <div class="product-info">
        <a href="{{ route('products.show', $product->id) }}">
            <h3 class="product-title">{{ $product->name }}</h3>
        </a>
        <div class="ratings">
            <div class="text-warning d-inline-block">
                {!! render_stars($product->rating) !!}
            </div>
            <span>{{ $product->sold_count ?? 0 }} {{ __('frontend.sold') }}</span>
        </div>

        <div class="price">{!! format_currency($product->sell_price, true) !!}</div>
    </div>
</div>
