@extends('frontend.layouts.app')

@section('content')
    <div class="page-title">
        <div class="wide-container">
            <h1>{{ __('frontend.confirm_password') }}</h1>
        </div>
    </div>

    <div class="wide-container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                {{ __('frontend.plz_confirm_password_before_continuing') }}

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('frontend.password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-dark">
                                {{ __('frontend.confirm_password') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('frontend.forgot_your_password') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
