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
                    <form action="{{ route('admin.countries.update', $country->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.country') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.country') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                @php($appLanguages = get_languages())
                                <x-layouts.language-tabs :appLanguages="$appLanguages">
                                    @foreach($appLanguages as $appLanguage)
                                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                            <div class="row">
                                                <x-form.input type="text" name="name[{{ $appLanguage->code }}]" key="id-name-[{{ $appLanguage->code }}]" label="true"
                                                              labelName="{{ __('admin.name') }}" required="true"
                                                              value="{{ $country->getTranslation('name', $appLanguage->code) }}"/>
                                                <x-form.input type="text" name="nationality[{{ $appLanguage->code }}]" key="id-nationality-[{{ $appLanguage->code }}]" label="true"
                                                              labelName="{{ __('admin.nationality') }}" required="true"
                                                              value="{{ $country->getTranslation('nationality', $appLanguage->code) }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.select col="col-md-6" label="true" name="currency_id" required="true" value="{{ $country->currency_id }}"  :options="$currencies" labelName="{{ __('admin.currency') }}"/>
                                    <x-form.select col="col-md-6" label="true" name="timezone" required="true" :options="get_timezones()" value="{{ $country->timezone }}" labelName="{{ __('admin.timezone') }}"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

