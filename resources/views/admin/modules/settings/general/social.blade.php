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
                    <form action="{{ route('admin.settings.social.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.social_media') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.social_medial') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-form.input col="col-md-6" type="url" label="true" name="social_facebook" labelName="{{ trans('admin.facebook') }}" value="{{ $settings->where('key', 'social_facebook')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" type="url"  label="true" name="social_youtube" labelName="{{ trans('admin.youtube') }}" value="{{ $settings->where('key', 'social_youtube')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" type="url"  label="true" name="social_instagram" labelName="{{ trans('admin.instagram') }}" value="{{ $settings->where('key', 'social_instagram')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" type="url"  label="true" name="social_twitter" labelName="{{ trans('admin.twitter') }}" value="{{ $settings->where('key', 'social_twitter')->first()?->value }}"/>
                                    <x-form.input col="col-md-6" type="url"  label="true" name="social_linkedin" labelName="{{ trans('admin.linkedin') }}" value="{{ $settings->where('key', 'social_linkedin')->first()?->value }}"/>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
