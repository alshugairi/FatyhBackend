@extends('account.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ trans('frontend.account_info') }}</h4>
    </div>
    <form action="{{ route('account.info.update') }}" method="POST">
        @csrf
        <div class="row">
            <x-form.input col="col-md-6" name="name" required="true" value="{{ auth()->user()->name }}" labelName="{{ trans('frontend.name') }}"/>
            <x-form.input col="col-md-6" name="email" disabled="true" value="{{ auth()->user()->email }}" labelName="{{ trans('frontend.email') }}"/>
            <x-form.tel col="col-md-6" type="tel" name="phone" required="true" value="{{ auth()->user()->phone }}" labelName="{{ trans('frontend.phone') }}"/>
        </div>
        <button type="submit" class="btn btn-primary mt-3">{{ trans('frontend.update_info') }}</button>
    </form>
@endsection

