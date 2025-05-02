@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.collections.update', $collection->id) }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.collection') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.collection') }}"/>
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
                                                      value="{{ $collection->getTranslation('name', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.name') }}"/>

                                        <x-form.textarea name="description[{{ $appLanguage->code }}]"
                                                      key="id-description-{{ $appLanguage->code }}"
                                                      value="{{ $collection->getTranslation('description', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.description') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                       <div class="row">
                           <x-form.switch col="col-md-4" label="true" name="is_active" key="input-is_active" value="{{ $collection->is_active }}" labelName="{{ trans('admin.active') }}"/>
                           <div class="clearfix"></div>
                           <div class="col-md-4 mb-3">
                               <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                               <div class="img-card">
                                   @if(!empty($collection->image))
                                       <img class="img-fluid imagePreview" src="{{ get_full_image_url($collection->image) }}">
                                   @endif
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

