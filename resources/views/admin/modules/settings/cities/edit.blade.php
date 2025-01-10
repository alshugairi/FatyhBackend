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
                    <form action="{{ route('admin.cities.update', $city->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.city') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.city') }}"/>
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
                                                              value="{{ $city->getTranslation('name', $appLanguage->code) }}"
                                                              label="true" labelName="{{__('admin.name') }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.select label="true" key="input-country_id" name="country_id" value="{{ $city->country_id }}" :options="$countries" labelName="{{ trans('admin.country') }}"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

