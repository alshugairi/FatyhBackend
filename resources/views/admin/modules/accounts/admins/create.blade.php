@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.admins.store') }}" method="post" id="submitForm">
        @method('post')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.create') }} {{ __('admin.admin') }}</h3>
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
                            <x-form.input col="col-4" type="text" label="true" key="input-name" name="name" required="true" labelName="{{ trans('admin.name') }}"/>
                            <x-form.input col="col-4" type="email" label="true" key="input-email" name="email" required="true" labelName="{{ trans('admin.email') }}"/>
                            <x-form.input col="col-4" type="text" label="true" key="input-phone" name="phone" labelName="{{ trans('admin.phone') }}"/>
                            <x-form.select col="col-4" label="true" required="true" key="input-role" name="role" :options="$roles" labelName="{{ trans('admin.role') }}"/>
                            <x-form.input col="col-4" type="password" label="true" required="true" key="input-password" name="password" labelName="{{ trans('admin.password') }}" autocomplete="new-password"/>
                            <x-form.input col="col-4" type="password" label="true" required="true" key="input-password-confirmation" name="password-confirmation" labelName="{{ trans('admin.confirm_password') }}"/>
                            <x-form.switch col="col-4" label="true" name="status" value="1" labelName="{{ trans('admin.active') }}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

