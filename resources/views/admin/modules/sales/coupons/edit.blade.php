@use(App\Enums\CouponType)
@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.coupon') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.coupon') }}"/>
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
                                                      value="{{ $coupon->getTranslation('name', $appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.name') }}"/>

                                        <x-form.textarea name="description[{{ $appLanguage->code }}]"
                                                         key="id-description-{{ $appLanguage->code }}"
                                                         value="{{ $coupon->getTranslation('description', $appLanguage->code) }}"
                                                         label="true" labelName="{{__('admin.description') }}"/>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                       <div class="row">
                           <x-form.input col="col-md-4" type="text" label="true" name="code" required="true" value="{{ $coupon->code }}"  labelName="{{ trans('admin.code') }}"/>
                           <x-form.select col="col-md-4" label="true" name="type" :options="CouponType::asString()" required="true" value="{{ $coupon->type }}"  labelName="{{ trans('admin.type') }}"/>
                           <x-form.input col="col-md-4" type="number" label="true" name="value" required="true" value="{{ $coupon->value }}"  labelName="{{ trans('admin.value') }}"/>
                           <x-form.input col="col-md-4" type="date" label="true" name="start_date" required="true" value="{{ $coupon->start_date->format('Y-m-d') }}" labelName="{{ trans('admin.start_date') }}"/>
                           <x-form.input col="col-md-4" type="date" label="true" name="end_date" required="true" value="{{ $coupon->end_date->format('Y-m-d') }}" labelName="{{ trans('admin.end_date') }}"/>

                           <x-form.input col="col-md-4" type="number" label="true" name="max_usage" value="{{ $coupon->max_usage }}" labelName="{{ trans('admin.max_usage') }}"/>
                           <x-form.input col="col-md-4" type="number" label="true" name="limit_per_user" value="{{ $coupon->limit_per_user }}" labelName="{{ trans('admin.limit_per_user') }}"/>

                           <div class="clearfix"></div>
                           <div class="col-md-4 mb-3">
                               <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.image') }}"/>
                               <div class="img-card">
                                   @if(!empty($coupon->image))
                                       <img class="img-fluid imagePreview" src="{{ get_full_image_url($coupon->image) }}">
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

