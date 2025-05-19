<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ get_setting('company_name', 'Fatyh') }} | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ get_setting('theme_favicon') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/adminlte.rtl.css">
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/rtl.css">
    @else
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/adminlte.css">
    @endif
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/custom.css">
</head>
<body class="login-body">

    <div class="container-login">
        <div class="left-panel position-relative">
            <div class="position-absolute hand-icon">
                <img class="w-100" src="{{ asset('public/assets/admin/images/hand.png') }}" alt="Hand Icon">
            </div>

            <div class="bottom-0 left-0 position-absolute mb-5 w-100 p-2">
                <h4 class="text-white">
                    Partnership for <br> Business Growth
                </h4>
                <small class="text-gray">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididun.</small>
            </div>
        </div>
        <div class="right-panel">
            <span class="close-btn">×</span>
            <div class="mt-5 text-center">
                <img src="{{ asset('public/assets/admin/images/user.png') }}" alt="User Icon" class="user-icon">
            </div>
            <h2 class="h4 text-center">Sign In Your Account</h2>
            <div>
                @include('flash::message')
                @if(session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <form method="POST" action="{{ route('admin.authenticate') }}">
                @csrf
                <div class="mb-3">
                    <div class="input-group mb-2 mr-sm-2 custom-input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ __('admin.email') }}"
                               name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="input-group mb-2 mr-sm-2 custom-input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="{{ __('admin.password') }}"
                               name="password" required>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 d-flex justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">{{ __('admin.remember_me') }}</label>
                    </div>
                    <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-lg btn-primary w-100 mb-3 border-0">{{ __('admin.login') }}</button>
                <p class="mb-0 text-center mt-3 fw-bold text-gray">
                    Don't have an account?
                    <a href="{{ route('admin.register') }}" class="text-decoration-none- text-primary">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
