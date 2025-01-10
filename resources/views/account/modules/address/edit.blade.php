@extends('account.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ trans('frontend.edit_address') }}</h4>
    </div>
    <form action="{{ route('account.address.update', $address->id) }}" method="POST">
        @method('put')
        @csrf
        <div class="row">
            <x-form.input col="col-md-6" name="full_name" required="true" labelName="{{ trans('frontend.full_name') }}" value="{{ $address->full_name }}"/>
            <x-form.select col="col-md-6" name="address_type" :options="['shipping' => trans('frontend.shipping'), 'billing' => trans('frontend.billing')]"
                           required="true" labelName="{{ trans('frontend.address_type') }}" value="{{ $address->address_type }}"/>
            <x-form.tel col="col-md-6" type="tel" name="phone" required="true"  labelName="{{ trans('frontend.phone') }}" value="{{ $address->phone }}"/>
            <x-form.input col="col-md-6" name="email" labelName="{{ trans('frontend.email') }}" value="{{ $address->email }}"/>

            <x-form.select col="col-md-6" name="country_id" :options="$countries" required="true" labelName="{{ trans('frontend.country') }}" value="{{ $address->country_id }}"/>
            <x-form.select col="col-md-6" name="city_id" :options="$cities" required="true" labelName="{{ trans('frontend.city') }}" value="{{ $address->city_id }}"/>

            <x-form.input col="col-md-6" name="address_line_1" required="true" labelName="{{ trans('frontend.address_line_1') }}" value="{{ $address->address_line_1 }}"/>
            <x-form.input col="col-md-6" name="address_line_2" labelName="{{ trans('frontend.address_line_2') }}" value="{{ $address->address_line_2 }}"/>
            <x-form.input col="col-md-6" name="postal_code" labelName="{{ trans('frontend.postal_code') }}" value="{{ $address->postal_code }}"/>

            <div class="col-md-6">
                <div class="form-check @error('is_default') is-invalid @enderror">
                    <input class="form-check-input" type="checkbox" name="is_default" id="is_default" value="1" {{ $address->is_default ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_default">
                        {{ trans('frontend.set_as_default') }}
                    </label>
                </div>
                @error('is_default') <span class="text-danger fw-bold">{{  $message  }}</span> @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-dark mt-3">{{ trans('frontend.save_address') }}</button>
    </form>
@endsection
