@php
    $dateFormats = [
        'Y-m-d' => 'YYYY-MM-DD (' . now()->format('Y-m-d') . ')',
        'd-m-Y' => 'DD-MM-YYYY (' . now()->format('d-m-Y') . ')',
        'm/d/Y' => 'MM/DD/YYYY (' . now()->format('m/d/Y') . ')',
        'd/m/Y' => 'DD/MM/YYYY (' . now()->format('d/m/Y') . ')',
        'F j, Y' => 'Month Day, Year (' . now()->format('F j, Y') . ')',
        'j F, Y' => 'Day Month, Year (' . now()->format('j F, Y') . ')',
        'Y/m/d' => 'YYYY/MM/DD (' . now()->format('Y/m/d') . ')',
        'M d, Y' => 'Mon Day, Year (' . now()->format('M d, Y') . ')',
        'd M Y' => 'Day Mon Year (' . now()->format('d M Y') . ')',
    ];

    $timeFormats = [
        'H:i' => '24-hour (HH:MM) (' . now()->format('H:i') . ')',
        'H:i:s' => '24-hour (HH:MM:SS) (' . now()->format('H:i:s') . ')',
        'h:i A' => '12-hour (HH:MM AM/PM) (' . now()->format('h:i A') . ')',
        'h:i:s A' => '12-hour (HH:MM:SS AM/PM) (' . now()->format('h:i:s A') . ')',
        'g:i A' => '12-hour no leading zero (H:MM AM/PM) (' . now()->format('g:i A') . ')',
        'g:i:s A' => '12-hour no leading zero with seconds (H:MM:SS AM/PM) (' . now()->format('g:i:s A') . ')',
    ];
    $currencies = \App\Models\Currency::allCurrencies();
    $positions = ['left' => __('admin.left'), 'right' => __('admin.right')];

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
                    <form action="{{ route('admin.settings.site.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.site') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.site') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-form.select col="col-md-6" label="true" name="site_date_format" required="true" :options="$dateFormats" labelName="{{ trans('admin.date_format') }}" value="{{ $settings->where('key', 'site_date_format')->first()?->value }}"/>
                                    <x-form.select col="col-md-6" label="true" name="site_time_format" required="true" :options="$timeFormats" labelName="{{ trans('admin.time_format') }}" value="{{ $settings->where('key', 'site_time_format')->first()?->value }}"/>
                                    <x-form.select col="col-md-6" label="true" name="site_currency_id" required="true" :options="$currencies" labelName="{{ trans('admin.default_currency') }}" value="{{ $settings->where('key', 'site_currency_id')->first()?->value }}"/>
                                    <x-form.select col="col-md-6" label="true" name="site_currency_position" required="true" :options="$positions" labelName="{{ trans('admin.currency_position') }}" value="{{ $settings->where('key', 'site_currency_position')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" type="number" name="site_precision" required="true" labelName="{{ trans('admin.default_precision') }}" value="{{ $settings->where('key', 'site_precision')->first()?->value }}"/>

                                    <x-form.input col="col-md-6" label="true" name="site_android_app_link" labelName="{{ trans('admin.android_app_link') }}" value="{{ $settings->where('key', 'site_android_app_link')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="site_ios_app_link" labelName="{{ trans('admin.ios_app_link') }}" value="{{ $settings->where('key', 'site_ios_app_link')->first()?->value }}"/>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
