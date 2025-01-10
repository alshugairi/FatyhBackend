@extends('account.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ __('frontend.change_password') }}</h4>
    </div>
    <form action="{{ route('account.password.update') }}" method="POST">
        @csrf
        <div class="row">
            <x-form.input col="col-md-6" name="old_password" type="password" required="true" labelName="{{ __('frontend.old_password') }}"/>
            <div class="clearfix"></div>
            <x-form.input col="col-md-6" name="password" type="password" required="true" labelName="{{ __('frontend.new_password') }}"/>
            <x-form.input col="col-md-6" name="password_confirmation" type="password" required="true" labelName="{{ __('frontend.confirm_password') }}"/>
        </div>
        <button type="submit" class="btn btn-primary mt-3">{{ __('frontend.update_password') }}</button>
    </form>
@endsection
