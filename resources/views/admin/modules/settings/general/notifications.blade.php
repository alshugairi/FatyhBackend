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
                    <form action="{{ route('admin.settings.mail.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.notifications') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.notifications') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-form.input col="col-md-6" label="true" name="mail_host" required="true" labelName="{{ trans('admin.host') }}" value="{{ $settings->where('key', 'mail_host')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="mail_port" required="true" labelName="{{ trans('admin.port') }}" value="{{ $settings->where('key', 'mail_port')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="mail_username" required="true" labelName="{{ trans('admin.username') }}" value="{{ $settings->where('key', 'mail_username')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" type="password" name="mail_password" required="true" labelName="{{ trans('admin.password') }}" value="{{ $settings->where('key', 'mail_password')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="mail_from_name" required="true" labelName="{{ trans('admin.from_name') }}" value="{{ $settings->where('key', 'mail_from_name')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" label="true" name="mail_from_email" required="true" labelName="{{ trans('admin.from_email') }}" value="{{ $settings->where('key', 'mail_from_email')->first()?->value }}"/>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
