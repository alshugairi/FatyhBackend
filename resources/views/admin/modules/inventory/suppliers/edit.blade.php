@use(App\Enums\CouponType)
@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.supplier') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.supplier') }}"/>
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
                                        <x-form.input col="col-md-4" type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                                      key="id-name-{{ $appLanguage->code }}" required="true"
                                                      value="{{ $supplier->getTranslation('name', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.name') }}"/>

                                        <x-form.input col="col-md-4" name="company_name[{{ $appLanguage->code }}]"
                                                         key="id-company_name-{{ $appLanguage->code }}" required="true"
                                                         value="{{ $supplier->getTranslation('company_name', $appLanguage->code) }}"
                                                         label="true" labelName="{{__('admin.company_name') }}"/>

                                        <x-form.input col="col-md-4" name="address[{{ $appLanguage->code }}]"
                                                         key="id-address-{{ $appLanguage->code }}"
                                                         value="{{ $supplier->getTranslation('address', $appLanguage->code) }}"
                                                         label="true" labelName="{{__('admin.address') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                       <div class="row">
                           <x-form.input col="col-md-4" label="true" name="email" value="{{ $supplier->email }}" labelName="{{ trans('admin.email') }}"/>
                           <x-form.input col="col-md-4" label="true" name="phone" value="{{ $supplier->phone }}" labelName="{{ trans('admin.phone') }}"/>
                           <x-form.input col="col-md-4" label="true" name="postal_code" value="{{ $supplier->postal_code }}" labelName="{{ trans('admin.postal_code') }}"/>
                           <x-form.input col="col-md-4" label="true" name="tax_id" value="{{ $supplier->tax_id }}" labelName="{{ trans('admin.tax_id') }}"/>
                           <x-form.switch col="col-md-4" label="true" name="status" key="input-status" value="{{ $supplier->status }}" labelName="{{ trans('admin.active') }}"/>
                           <div class="clearfix"></div>
                           <div class="col-md-4 mb-3">
                               <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                               <div class="img-card">
                                   @if(!empty($supplier->image))
                                       <img class="img-fluid imagePreview" src="{{ get_full_image_url($supplier->image) }}">
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

