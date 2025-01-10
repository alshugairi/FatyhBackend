@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.settings') }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('admin.partial.settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <form action="{{ route('admin.settings.payment_gateways.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.payment_gateways') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.payment_gateways') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="col-md-12 fw-bold">{{ __('admin.paypal') }}</h5>
                                    <x-form.input col="col-md-6" label="true" name="payment_paypal_app_id" labelName="{{ trans('admin.app_id') }}" value="{{ $settings->where('key', 'payment_paypal_app_id')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="payment_paypal_client_id" labelName="{{ trans('admin.client_id') }}" value="{{ $settings->where('key', 'payment_paypal_client_id')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="payment_paypal_client_secret" labelName="{{ trans('admin.client_secret') }}" value="{{ $settings->where('key', 'payment_paypal_client_secret')->first()?->value }}"/>
                                </div>
                                <hr>
                                <div class="row">
                                    <h5 class="col-md-12 fw-bold">{{ __('admin.stripe') }}</h5>
                                    <x-form.input col="col-md-6" label="true" name="payment_stripe_key" labelName="{{ trans('admin.key') }}" value="{{ $settings->where('key', 'payment_stripe_key')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="payment_stripe_secret" labelName="{{ trans('admin.secret') }}" value="{{ $settings->where('key', 'payment_stripe_secret')->first()?->value }}"/>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
