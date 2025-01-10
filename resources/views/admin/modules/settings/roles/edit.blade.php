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
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="post" id="submitForm">
                        @method('put')
                        @csrf
                        <div class="card mb-1">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('admin.create') }} {{ __('admin.role') }}</h3>
                                <div class="card-tools">
                                    <x-datatable.save module="{{ __('admin.role') }}"/>
                                </div>
                            </div>
                            <div class="card-body">
                                <x-form.input type="text" name="name" required="true" key="id-input" value="{{ $role->name }}" label="true" labelName="{{ __('admin.name') }}"/>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                @foreach($groupedPermissions as $key => $groupedPermission)
                                    <div class="mb-2">
                                        <h5 class="pb-1">{{ __('admin.'. $key) }}</h5>
                                        <div class="row">
                                            @foreach($groupedPermission as $permission)
                                                <div class="col-md-3">
                                                    <div class="form-check form-switch mb-2">
                                                        <input class="form-check-input" type="checkbox" id="{{ $permission->name }}"
                                                               name="role_permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $rolePermissions))>
                                                        <label class="form-check-label" for="{{ $permission->name }}">{{ __('admin.'. $permission->action) }}</label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                                @error('role_permissions') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

