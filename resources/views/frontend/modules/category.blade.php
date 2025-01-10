@extends('frontend.layouts.app')

@section('content')
    <div class="page-title" style="background-image: url()">
        <div class="wide-container">
            <h1>{{ $category->name }}</h1>
        </div>
    </div>

<div class="wide-container mt-4">
    <div class="row">
        <div class="col-md-2">
            <div class="filter-section">
                <h5 class="filter-title">Filter By</h5>

                <div class="filter-item">
                    <label for="search">Search</label>
                    <input type="text" id="search" class="form-control" placeholder="Search products...">
                </div>

                <!-- Category Filter -->
                <div class="filter-item">
                    <h6 class="filter-heading" data-toggle="collapse" data-target="#categoryFilter">Category</h6>
                    <ul id="categoryFilter" class="filter-options">
                        <li><input type="checkbox" id="category1"> <label for="category1">Hoodies</label></li>
                        <li><input type="checkbox" id="category2"> <label for="category2">Sweatshirts</label></li>
                        <li><input type="checkbox" id="category3"> <label for="category3">Jackets</label></li>
                    </ul>
                </div>

                <!-- Price Range Filter -->
                <div class="filter-item">
                    <h6 class="filter-heading" data-toggle="collapse" data-target="#priceFilter">Price Range</h6>
                    <div id="priceFilter" class="price-range">
                        <input type="range" class="form-range" min="0" max="1000" step="10" id="priceRange">
                        <div class="range-values">
                            <span id="min-price">0 EGP</span> - <span id="max-price">1000 EGP</span>
                        </div>
                    </div>
                </div>

                <!-- Brand Filter -->
                <div class="filter-item">
                    <h6 class="filter-heading" data-toggle="collapse" data-target="#brandFilter">Brand</h6>
                    <ul id="brandFilter" class="filter-options">
                        <li><input type="checkbox" id="brand1"> <label for="brand1">Brand A</label></li>
                        <li><input type="checkbox" id="brand2"> <label for="brand2">Brand B</label></li>
                        <li><input type="checkbox" id="brand3"> <label for="brand3">Brand C</label></li>
                    </ul>
                </div>

                <!-- Color Filter -->
                <div class="filter-item">
                    <h6 class="filter-heading" data-toggle="collapse" data-target="#colorFilter">Color</h6>
                    <ul id="colorFilter" class="filter-options colors">
                        <li><input type="checkbox" id="color1"> <label for="color1" style="background-color: #000000;"></label></li>
                        <li><input type="checkbox" id="color2"> <label for="color2" style="background-color: #FF0000;"></label></li>
                        <li><input type="checkbox" id="color3"> <label for="color3" style="background-color: #0000FF;"></label></li>
                    </ul>
                </div>

                <!-- Rating Filter -->
                <div class="filter-item">
                    <h6 class="filter-heading" data-toggle="collapse" data-target="#ratingFilter">Rating</h6>
                    <ul id="ratingFilter" class="filter-options">
                        <li><input type="radio" name="rating" id="rating5"> <label for="rating5">⭐⭐⭐⭐⭐</label></li>
                        <li><input type="radio" name="rating" id="rating4"> <label for="rating4">⭐⭐⭐⭐ & Up</label></li>
                        <li><input type="radio" name="rating" id="rating3"> <label for="rating3">⭐⭐⭐ & Up</label></li>
                    </ul>
                </div>

                <!-- Apply Filter Button -->
                <button class="btn btn-primary mt-3 w-100">Apply Filters</button>
            </div>


        </div>
        <div class="col-md-10 p-0">
            <div class="product-grid">
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-2 p-0">
                        @include('frontend.partial.products.product_card')
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

