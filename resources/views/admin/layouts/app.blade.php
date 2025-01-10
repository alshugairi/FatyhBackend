@include('admin.layouts.header')
@include('admin.layouts.navbar')
@include('admin.layouts.sidebar')
<main class="app-main">
    <div class="container-fluid alerts">
        @include('flash::message')
    </div>
    @yield('content')
</main>
@include('admin.layouts.footer')
