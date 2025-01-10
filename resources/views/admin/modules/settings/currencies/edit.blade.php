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
                    <form action="{{ route('admin.currencies.update', $currency->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.currency') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.currency') }}"/>
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
                                                              value="{{ $currency->getTranslation('name', $appLanguage->code) }}"
                                                              label="true" labelName="{{__('admin.name') }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.input col="col-md-6" type="text" label="true" name="code" value="{{ $currency->code }}" required="true" labelName="{{ trans('admin.code') }}"/>
                                    <x-form.input col="col-md-6" type="text" label="true" name="symbol" value="{{ $currency->symbol }}" required="true" labelName="{{ trans('admin.symbol') }}"/>
                                    <x-form.input col="col-md-6" type="number" label="true" name="exchange_rate" step="any" value="{{ $currency->exchange_rate }}" required="true" labelName="{{ trans('admin.exchange_rate') }}"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

