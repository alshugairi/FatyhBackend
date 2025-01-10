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
                    <form action="{{ route('admin.settings.theme.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.theme') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.theme') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        @php($themeLogo = $settings->where('key', 'theme_logo')->first()?->value)
                                        <x-form.input type="file" label="true" name="theme_logo" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                                        <div class="img-card">
                                            @if(!empty($themeLogo))
                                                <img class="img-fluid imagePreview" src="{{ get_full_image_url($themeLogo) }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        @php($themeFavicon = $settings->where('key', 'theme_favicon')->first()?->value)
                                        <x-form.input type="file" label="true" name="theme_favicon" classes="imageInput" labelName="{{ trans('admin.favicon') }}"/>
                                        <div class="img-card">
                                            @if(!empty($themeFavicon))
                                                <img class="img-fluid imagePreview" src="{{ get_full_image_url($themeFavicon) }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        @php($themeLightLogo = $settings->where('key', 'theme_light_logo')->first()?->value)
                                        <x-form.input type="file" label="true" name="theme_light_logo" classes="imageInput" labelName="{{ trans('admin.light_logo') }}"/>
                                        <div class="img-card">
                                            @if(!empty($themeLightLogo))
                                                <img class="img-fluid imagePreview" src="{{ get_full_image_url($themeLightLogo) }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
