<form action="{{ route('products.index') }}" method="GET" id="filterProductsForm">
    <div class="filter-section mb-3">
        <h5 class="filter-title">{{ __('frontend.filter_by') }}</h5>
        <div class="filter-item">
            <label for="search">{{ __('frontend.search') }}</label>
            <input type="text" id="search" name="q" class="form-control" value="{{ request('q', '') }}"
                   placeholder="{{ __('frontend.search_for_products') }}...">
        </div>
{{--        <div class="filter-item">--}}
{{--            <h6 class="filter-heading" data-toggle="collapse" data-target="#categoryFilter">{{ __('frontend.categories') }}</h6>--}}
{{--            <ul id="categoryFilter" class="filter-options">--}}
{{--                @foreach(get_categories() as $filterCategory)--}}
{{--                    <li>--}}
{{--                        <input type="checkbox" id="category{{ $filterCategory->id }}" name="categoryIds[]" value="{{ $filterCategory->id }}"--}}
{{--                               @if(in_array($filterCategory->id, request('categoryIds', []))) checked @endif>--}}
{{--                        <label for="category{{ $filterCategory->id }}">{{ $filterCategory->name }}</label>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
        <div class="filter-item">
            <h6 class="filter-heading" data-toggle="collapse" data-target="#brandFilter">{{ __('frontend.brands') }}</h6>
            <input type="hidden" name="brand" value="{{ request('brand', '') }}">
            <ul id="brandFilter" class="filter-options">
                @foreach(get_brands() as $filterBrand)
                    <li>
                        <input type="checkbox" class="filter-brand" id="brand{{ $filterBrand->id }}" value="{{ $filterBrand->id }}"
                               @if(in_array($filterBrand->id, explode(',', request('brand', '')))) checked @endif>
                        <label for="brand{{ $filterBrand->id }}">{{ $filterBrand->name }}</label>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="filter-item">
            <h6 class="filter-heading" data-toggle="collapse" data-target="#priceFilter">{{ __('frontend.price_range') }}</h6>
            <div id="priceFilter" class="price-range">
                <input type="number" name="min_price" class="form-control mb-2"
                       value="{{ request('min_price', '') }}" placeholder="{{ __('frontend.min_price') }}">
                <input type="number" name="max_price" class="form-control"
                       value="{{ request('max_price', '') }}" placeholder="{{ __('frontend.max_price') }}">
            </div>
        </div>
        <div class="filter-item">
            <h6 class="filter-heading" data-toggle="collapse" data-target="#ratingFilter">{{ __('frontend.rating') }}</h6>
            <ul id="ratingFilter" class="filter-options text-warning">
                @for($i = 5; $i >= 1; $i--)
                    <li>
                        <input type="radio" name="rating" id="rating{{ $i }}" value="{{ $i }}"
                               @if(request('rating') == $i) checked @endif>
                        <label for="rating{{ $i }}">{!! render_stars($i) !!}</label>
                    </li>
                @endfor
            </ul>
        </div>

        <button type="submit" class="btn btn-dark w-100">{{ __('frontend.apply_filters') }}</button>
    </div>
</form>
