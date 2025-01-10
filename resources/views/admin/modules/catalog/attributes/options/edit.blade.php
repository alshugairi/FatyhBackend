@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.attributes.options.update', ['attribute' => $attribute->id , 'option' => $option->id]) }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.attribute') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.attribute') }}"/>
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
                                                      value="{{ $option->getTranslation('name', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.name') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

