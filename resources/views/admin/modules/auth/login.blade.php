<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Admin | Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/overlayscrollbars.min.css">
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/bootstrap-icons.min.css">
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/adminlte.rtl.css">
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/rtl.css">
    @else
        <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/adminlte.css">
    @endif
    <link rel="stylesheet" href="{{ asset('public/assets/admin') }}/css/custom.css">
</head>

<body>
    <div class="login--page w-100">
        <div class="row min-vh-100 p-0 m-0">
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center text-white" style="background:#1F2D3A;">
                <div class="text-center">
                    <img src="{{ asset('public/assets/admin') }}/images/logo.png" alt="Logo" class="img-fluid mb-4 logo">
                    <h1>{{ __('admin.login_welcome_msg') }}</h1>
                    <p>{{ __('admin.login_description') }}</p>
                </div>
            </div>

            <div class="col-md-6 d-flex align-items-center justify-content-center bg-light position-relative">
                <div class="language-switcher position-absolute" style="top: 20px; right: 20px;">
                    <select class="form-select form-select-sm" onchange="switchLanguage(this)">
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }} data-href="{{ route('language.switch', 'en') }}">{{ __('admin.english') }}</option>
                        <option value="ar" {{ app()->getLocale() === 'ar' ? 'selected' : '' }} data-href="{{ route('language.switch', 'ar') }}">{{ __('admin.arabic') }}</option>
                    </select>
                </div>
                <div class="login-box w-100">
                    @include('flash::message')
                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="px-180">
                        <h3 class="login-box-msg fw-bold">{{ __('admin.signin') }}</h3>

                        <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('admin.authenticate') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('admin.email') }}</label>
                                <input id="email" type="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">{{ __('admin.password') }}</label>
                                    {{--                        <a href="#">--}}
                                    {{--                            <small>{{ __('admin.forgot_password') }}</small>--}}
                                    {{--                        </a>--}}
                                </div>
                                <div class="input-group input-group-merge">
                                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password">
                                    {{--                            <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>--}}
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                     <strong>{{ $message }}</strong>
                                 </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> {{ __('admin.remember_me') }} </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary-light btn-lg d-grid w-100" type="submit">{{ __('admin.login') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/assets/admin') }}/js/overlayscrollbars.browser.es6.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/popper.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('public/assets/admin') }}/js/adminlte.js"></script>
    <script>
        function switchLanguage(select) {
            const selectedOption = select.options[select.selectedIndex];
            const href = selectedOption.getAttribute('data-href');
            if (href) {
                window.location.href = href;
            }
        }
    </script>
</body>
</html>
