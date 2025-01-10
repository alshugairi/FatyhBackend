@extends('frontend.layouts.app')

@section('content')
    <div class="page-title">
        <div class="wide-container">
            <h1>{{ __('frontend.register') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="border rounded-25 p-5 mt-3 mb-60">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="text-md-end">{{ __('frontend.name') }}</label>
                            <div class="form-group mt-3">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="text-md-end">{{ __('frontend.email') }}</label>
                            <div class="form-group mt-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="text-md-end">{{ __('frontend.password') }}</label>
                            <div class="form-group mt-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="text-md-end">{{ __('frontend.confirm_password') }}</label>
                            <div class="form-group mt-3">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="mb-0">
                            <button type="submit" class="btn btn-dark w-100">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
