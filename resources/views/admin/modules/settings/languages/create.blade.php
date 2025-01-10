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
                    <form action="{{ route('admin.languages.store') }}" method="post" id="submitForm">
                        @method('post')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.create') }} {{ __('admin.language') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.language') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <x-form.input col="col-md-6" type="text" name="name" required="true" key="id-input" label="true" labelName="{{ __('admin.name') }}"/>
                                    <x-form.input col="col-md-6" type="text" name="code" required="true" key="id-code" label="true" labelName="{{ __('admin.code') }}"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

