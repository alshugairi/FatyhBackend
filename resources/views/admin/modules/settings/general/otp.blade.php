@php
    $otpTypes = ['both' => __('admin.both'), 'sms' => __('admin.sms'), 'email' => __('admin.email')];
    $otpDigitLimits = [6 => 6, 8 => 8, 10 => 10];
    $otpExpireTimes = [
               5 => 5 . ' ' .__('admin.minutes'),
               10 => 10 . ' ' .__('admin.minutes'),
               15 => 15 . ' ' .__('admin.minutes'),
               20 => 20 . ' ' .__('admin.minutes'),
               30 => 30 . ' ' .__('admin.minutes'),
               60 => 60 . ' ' .__('admin.minutes'),
           ];
@endphp
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
                    <form action="{{ route('admin.settings.otp.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.otp') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.otp') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-form.select col="col-md-6" label="true" name="otp_type" required="true" :options="$otpTypes" labelName="{{ trans('admin.type') }}" value="{{ $settings->where('key', 'otp_type')->first()?->value }}"/>
                                    <x-form.select col="col-md-6" label="true" name="otp_digit_limit" required="true" :options="$otpDigitLimits" labelName="{{ trans('admin.digit_limit') }}" value="{{ $settings->where('key', 'otp_digit_limit')->first()?->value }}"/>
                                    <x-form.select col="col-md-6" label="true" name="otp_expire_time" required="true" :options="$otpExpireTimes" labelName="{{ trans('admin.expire_time') }}" value="{{ $settings->where('key', 'otp_expire_time')->first()?->value }}"/>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

