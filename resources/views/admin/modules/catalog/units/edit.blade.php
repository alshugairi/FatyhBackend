@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.units.update', $unit->id) }}" method="post" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.unit') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.unit') }}"/>
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
                                                      value="{{ $unit->getTranslation('name', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.name') }}"/>

                                        <x-form.textarea name="description[{{ $appLanguage->code }}]"
                                                      key="id-description-{{ $appLanguage->code }}"
                                                      value="{{ $unit->getTranslation('description', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.description') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                       <div class="row">
                           <x-form.input col="col-md-4" type="text" label="true" name="code" required="true" value="{{ $unit->code }}"  labelName="{{ trans('admin.code') }}"/>
                           <x-form.switch col="col-md-4" label="true" name="status" key="input-status" value="{{ $unit->status }}" labelName="{{ trans('admin.active') }}"/>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

