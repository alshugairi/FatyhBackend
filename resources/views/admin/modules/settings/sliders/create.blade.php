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
                    <form action="{{ route('admin.sliders.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.create') }} {{ __('admin.slider') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.slider') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                               <div class="row">
                                   <x-form.input col="col-4" type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                                   <div class="clearfix"></div>
                                   <div class="img-card col-4">
                                       <img class="img-fluid imagePreview">
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
