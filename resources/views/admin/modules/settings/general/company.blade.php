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
                    <form action="{{ route('admin.settings.company.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.company') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.company') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-form.input col="col-md-6" label="true" name="company_name" required="true" labelName="{{ trans('admin.name') }}" value="{{ $settings->where('key', 'company_name')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="company_email" required="true" labelName="{{ trans('admin.email') }}" value="{{ $settings->where('key', 'company_email')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="company_phone" required="true" labelName="{{ trans('admin.phone') }}" value="{{ $settings->where('key', 'company_phone')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="company_website" labelName="{{ trans('admin.website') }}" value="{{ $settings->where('key', 'company_website')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="company_zip_code" required="true" labelName="{{ trans('admin.zip_code') }}" value="{{ $settings->where('key', 'company_zip_code')->first()?->value }}"/>
                                    <x-form.textarea label="true" name="company_address" required="true" labelName="{{ trans('admin.address') }}" value="{{ $settings->where('key', 'company_address')->first()?->value }}"/>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
