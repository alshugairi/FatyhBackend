@extends('admin.layouts.app')

@section('content')
    @include('admin.partial.settings.page_header')

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('admin.partial.settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <form action="{{ route('admin.taxes.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.create') }} {{ __('admin.tax') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.tax') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                @php($appLanguages = get_languages())
                                <x-layouts.language-tabs :appLanguages="$appLanguages">
                                    @foreach($appLanguages as $appLanguage)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                            <div class="row">
                                                <x-form.input type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                                              key="id-name-{{ $appLanguage->code }}" required="true"
                                                              value="{{ old('name.'.$appLanguage->code) }}"
                                                              label="true" labelName="{{ __('admin.name') }}"/>

                                                <x-form.textarea type="text" name="description[{{ $appLanguage->code }}]"
                                                                 key="id-description-{{ $appLanguage->code }}"
                                                                 value="{{ old('description.'.$appLanguage->code) }}"
                                                                 label="true" labelName="{{ __('admin.description') }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.input col="col-md-6" type="number" label="true" name="rate" required="true" labelName="{{ __('admin.rate') }}"/>
                                    <x-form.switch col="col-md-6" label="true" name="status" value="1" labelName="{{ trans('admin.active') }}"/>
                                    <div class="clearfix"></div>
                                    <div class="col-md-6 mb-3">
                                        <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                                        <div class="img-card">
                                            <img class="img-fluid imagePreview">
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

