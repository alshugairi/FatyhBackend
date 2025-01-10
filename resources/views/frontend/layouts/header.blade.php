<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    <title>@yield('title', get_setting('company_name', 'Shopifyze'))</title>
    <link rel="icon" type="image/png" href="{{ get_setting('theme_favicon') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Cairo:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/toastr.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/style.css">
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('assets/frontend') }}/css/rtl.css">
    @endif
    @stack('styles')
</head>
<body>
<!-- Top Bar -->
<div class="top-bar">
    <div class="wide-container d-flex justify-content-between align-items-center">
        <div class="currency-selector">
            <div class="dropdown">
                <button class="btn btn-link dropdown-toggle no-arrow text-decoration-none" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ LaravelLocalization::getCurrentLocaleNative() }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="languageDropdown">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li>
                            <a class="dropdown-item language-switch {{ $localeCode == LaravelLocalization::getCurrentLocale() ? 'active' : '' }}"
                               rel="alternate"
                               hreflang="{{ $localeCode }}"
                               href="{{ route('language.switch', $localeCode) }}" data-url="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                <span class="flag-icon flag-icon-{{ $properties['regional'] == 'en_GB' ? 'gb' : substr($properties['regional'], -2) }} me-2"></span>
                                {{ $properties['native'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="top-menu">
            <div class="social-links">
                @php
                    $facebook = get_setting('social_facebook');
                    $twitter = get_setting('social_twitter');
                    $instagram = get_setting('social_instagram');
                    $youtube = get_setting('social_youtube');
                    $linkedin = get_setting('social_linkedin');
                @endphp

                @if($facebook)
                    <a href="{{ $facebook }}" target="_blank"><i class="fab fa-facebook"></i></a>
                @endif

                @if($twitter)
                    <a href="{{ $twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                @endif

                @if($instagram)
                    <a href="{{ $instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif

                @if($youtube)
                    <a href="{{ $youtube }}" target="_blank"><i class="fab fa-youtube"></i></a>
                @endif

                @if($linkedin)
                    <a href="{{ $linkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="wide-container h-100">
        <div class="d-flex align-items-center justify-content-between h-100">
            <div class="logo-wrap">
                <a href="{{ route('home') }}">
                    <img src="{{ get_setting('theme_logo') }}" alt="Shopifyze" class="logo">
                </a>
            </div>

            <form class="search-form" action="{{ route('products.index') }}">
                <input type="search" name="q" class="search-input" placeholder="{{ __('frontend.search_for_products') }}">
                <button type="submit" class="search-button">
                    <i class="fa fa-search"></i>
                </button>
            </form>

            <div class="header-actions">
                <a href="tel:(686) 492-1044" class="contact-info text-decoration-none">
                    <i class="fas fa-phone"></i>
                    <span>{{ get_setting('company_phone') }}</span>
                </a>
                <a href="#" class="header-icon text-decoration-none dropdown-toggle hide-after" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <ul class="dropdown-menu wide-dropdown" aria-labelledby="userDropdown">
                    @auth
                        <li class="user-info">
                            <img src="{{ asset('assets/frontend/images/avatar.png') }}" alt="User Profile" class="profile-img">
                            <div class="user-details">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('account.dashboard') }}"><i class="fas fa-user"></i> {{ __('frontend.my_account') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.orders.index') }}"><i class="fas fa-box"></i> {{ __('frontend.my_orders') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.orders.return') }}"><i class="fas fa-undo"></i> {{ __('frontend.return_orders') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.change_password') }}"><i class="fas fa-user"></i> {{ __('frontend.account_info') }}</a></li>
                        <li><a class="dropdown-item" href="{{ route('account.address.index') }}"><i class="fas fa-map-marker-alt"></i> {{ __('frontend.address') }}</a></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket"></i> {{ __('frontend.logout') }}
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a class="btn btn-warning w-100 mb-2" href="{{ route('login') }}">{{ __('frontend.login') }}</a>
                        <div class="my-2 text-center fw-600">{{ __('frontend.or') }}</div>
                        <a class="btn btn-dark w-100 " href="{{ route('register') }}">{{ __('frontend.register') }}</a>
                    @endauth
                </ul>

                <a href="{{ route('compare.index') }}" class="header-icon text-decoration-none">
                    <i class="fas fa-random"></i>
                </a>
                <a href="{{ route('wishlist.index') }}" class="header-icon text-decoration-none">
                    <i class="fas fa-heart"></i>
                </a>
                <a href="{{ route('cart.index') }}" class="header-icon cart-icon text-decoration-none">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-amount">{{ \Cart::getTotal() }}</span>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="nav-container">
    <div class="wide-container">
        <div class="d-flex align-items-stretch">
            <div class="categories-wrap">
                <div class="categories-button">
                    <i class="fas fa-bars"></i>
                    <span class="mx-3">{{ __('frontend.categories') }}</span>
                </div>
                <div class="categories-menu">
                    @foreach(get_categories() as $menuCategory)
                    <div class="category-item">
                        <i class="{{ $menuCategory->icon }}"></i>
                        <span>{{ $menuCategory->name }}</span>
                        <i class="fas fa-chevron-right arrow"></i>
                        @php($subCategories = $menuCategory->children)
                        @if(count($subCategories) > 0)
                        <div class="submenu">
                            <div class="submenu-grid">
                                @foreach($subCategories as $subCategory)
                                    @php($subSubCategories = $subCategory->children)
                                    <div class="submenu-category">
                                        <h4>{{ $subCategory->name }}</h4>
                                        <ul class="submenu-links">
                                            @foreach($subSubCategories as $subSubCategory)
                                            <li><a href="{{ route('products.index', ['category' => $subSubCategory->id]) }}">{{ $subSubCategory->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            {!! render_primary_menu() !!}
        </div>
    </div>
</div>

