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
                    <form action="{{ route('admin.return_reasons.update', $returnReason->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.edit') }} {{ __('admin.return_reason') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.return_reason') }}"/>
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
                                                              value="{{ $returnReason->getTranslation('name', $appLanguage->code) }}"
                                                              label="true" labelName="{{__('admin.name') }}"/>

                                                <x-form.textarea name="description[{{ $appLanguage->code }}]"
                                                                 key="id-description-{{ $appLanguage->code }}"
                                                                 value="{{ $returnReason->getTranslation('description', $appLanguage->code) }}"
                                                                 label="true" labelName="{{__('admin.description') }}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </x-layouts.language-tabs>
                                <div class="row">
                                    <x-form.switch col="col-md-4" label="true" name="status" key="input-status" value="{{ $returnReason->status }}" labelName="{{ trans('admin.active') }}"/>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

