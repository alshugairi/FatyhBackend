@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.categories.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('post')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.create') }} {{ __('admin.category') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.category') }}"/>
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
                                                      value="{!! old('name.'.$appLanguage->code) !!}"
                                                      labelName="{{ __('admin.name') }}"/>

                                        <x-form.textarea type="text" name="description[{{ $appLanguage->code }}]"
                                                      key="id-description-{{ $appLanguage->code }}"
                                                      value="{!! old('description.'.$appLanguage->code) !!}"
                                                      labelName="{{ __('admin.description') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                        <div class="row">
                            <x-form.select col="col-md-4" name="parent_id" :options="$parentCategories" labelName="{{ trans('admin.parent_category') }}"/>
                            <x-form.input col="col-md-4" name="icon" labelName="{{ trans('admin.icon') }}"/>
                            <x-form.switch col="col-md-2" name="status" value="1" labelName="{{ trans('admin.active') }}"/>
                            <x-form.switch col="col-md-2" name="is_featured" value="1" labelName="{{ trans('admin.is_featured') }}"/>
                            <div class="clearfix"></div>
                            <div class="col-md-4 mb-3">
                                <x-form.input type="file" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
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

