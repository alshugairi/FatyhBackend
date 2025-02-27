@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.brands.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('post')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.create') }} {{ __('admin.brand') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.brand') }}"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
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
                            <x-form.switch col="col-md-2" label="true" name="status" value="1" labelName="{{ trans('admin.active') }}"/>
                            <x-form.switch col="col-md-2" name="is_featured" value="1" labelName="{{ trans('admin.is_featured') }}"/>
                            <div class="clearfix"></div>
                            <div class="col-md-4 mb-3">
                                <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                                <div class="img-card">
                                    <img class="img-fluid imagePreview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

