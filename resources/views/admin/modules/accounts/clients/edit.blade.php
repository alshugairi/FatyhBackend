@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.clients.update', $client->id) }}" method="post" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.client') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.user') }}"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                       <div class="row">
                           <x-form.input col="col-6" type="text" label="true" key="input-name" name="name" required="true" labelName="{{ trans('admin.name') }}" value="{{ $client->name }}"/>
                           <x-form.input col="col-6" type="email" label="true" key="input-email" name="email" required="true" labelName="{{ trans('admin.email') }}" value="{{ $client->email }}"/>
                           <x-form.input col="col-6" type="text" label="true" key="input-phone" name="phone" labelName="{{ trans('admin.phone') }}" value="{{ $client->phone }}"/>
                           <x-form.input col="col-6" type="password" label="true" key="input-password" name="password" labelName="{{ trans('admin.password') }}" autocomplete="new-password"/>
                           <x-form.input col="col-6" type="password" label="true" key="input-password-confirmation" name="password-confirmation" labelName="{{ trans('admin.confirm_password') }}"/>
                           <x-form.switch col="col-6" label="true" name="status" value="{{ $client->status }}" labelName="{{ trans('admin.active') }}"/>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

