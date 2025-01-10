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
                    <form action="{{ route('admin.settings.sms_gateways.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.sms_gateways') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.sms_gateways') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <h5 class="col-md-12 fw-bold">{{ __('admin.twilio') }}</h5>
                                    <x-form.input col="col-md-6" label="true" name="sms_twilio_account_sid" labelName="{{ trans('admin.account_sid') }}" value="{{ $settings->where('key', 'sms_twilio_account_sid')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="sms_twilio_auth_token" labelName="{{ trans('admin.auth_token') }}" value="{{ $settings->where('key', 'sms_twilio_auth_token')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="sms_twilio_from" labelName="{{ trans('admin.from') }}" value="{{ $settings->where('key', 'sms_twilio_from')->first()?->value }}"/>
                                </div>
                                <hr>
                                <div class="row">
                                    <h5 class="col-md-12 fw-bold">{{ __('admin.victorylink') }}</h5>
                                    <x-form.input col="col-md-6" label="true" name="sms_victorylink_username" labelName="{{ trans('admin.username') }}" value="{{ $settings->where('key', 'sms_victorylink_username')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="sms_victorylink_password" labelName="{{ trans('admin.password') }}" value="{{ $settings->where('key', 'sms_victorylink_password')->first()?->value }}"/>
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
