@include('frontend.layouts.header')
<main class="app-main">
    <div class="wide-container my-3">
        <div class="row">
            <div class="col-lg-2 col-md-4 sidebar">
                @include('account.layouts.sidebar')
            </div>

            <div class="col-lg-10 col-md-8 p-4">
                @include('flash::message')
                @yield('content')
            </div>
        </div>
    </div>
</main>
@include('frontend.layouts.footer')
