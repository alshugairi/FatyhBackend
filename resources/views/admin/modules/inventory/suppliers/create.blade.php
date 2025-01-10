@use(App\Enums\CouponType)
@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.suppliers.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('post')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.create') }} {{ __('admin.supplier') }}</h3>
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
                                                      value="{{ old('name.'.$appLanguage->code) }}"
                                                      label="true" labelName="{{ __('admin.name') }}"/>

                                        <x-form.input col="col-md-4" type="text" name="company_name[{{ $appLanguage->code }}]"
                                                         key="id-company_name-{{ $appLanguage->code }}" required="true"
                                                         value="{{ old('company_name.'.$appLanguage->code) }}"
                                                         label="true" labelName="{{ __('admin.company_name') }}"/>

                                        <x-form.input col="col-md-4" type="text" name="address[{{ $appLanguage->code }}]"
                                                         key="id-address-{{ $appLanguage->code }}"
                                                         value="{{ old('address.'.$appLanguage->code) }}"
                                                         label="true" labelName="{{ __('admin.address') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                        <div class="row">
                            <x-form.input col="col-md-4" label="true" name="email" labelName="{{ trans('admin.email') }}"/>
                            <x-form.input col="col-md-4" label="true" name="phone" labelName="{{ trans('admin.phone') }}"/>
                            <x-form.input col="col-md-4" label="true" name="postal_code" labelName="{{ trans('admin.postal_code') }}"/>
                            <x-form.input col="col-md-4" label="true" name="tax_id" labelName="{{ trans('admin.tax_id') }}"/>
                            <x-form.switch col="col-md-4" label="true" name="status" value="1" labelName="{{ trans('admin.active') }}"/>
                            <div class="clearfix"></div>
                            <div class="col-md-4 mb-3">
                                <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                                <div class="img-card">
                                    <img class="img-fluid imagePreview">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

