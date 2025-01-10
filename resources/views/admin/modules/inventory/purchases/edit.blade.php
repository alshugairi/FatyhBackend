@use(App\Enums\PurchaseStatus)
@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.purchases.update', $purchase->id) }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('put')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.edit') }} {{ __('admin.purchase') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.purchase') }}"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <x-form.input col="col-md-6" label="true" name="number" value="{{ $purchase->number }}" labelName="{{ trans('admin.reference_no') }}"/>
                            <x-form.input col="col-md-6" label="true" type="date" name="date" value="{{ $purchase->date }}"  required="true" labelName="{{ trans('admin.date') }}"/>
                            <x-form.select col="col-md-6" label="true" name="supplier_id" value="{{ $purchase->supplier_id }}"  required="true" :options="$suppliers" labelName="{{ trans('admin.supplier') }}"/>
                            <x-form.select col="col-md-6" label="true" name="status" value="{{ $purchase->status }}"  required="true" :options="PurchaseStatus::keyValue()" labelName="{{ trans('admin.status') }}"/>
                            <x-form.textarea name="notes" classes="editor" label="true" value="{{ $purchase->notes }}"  labelName="{{ __('admin.notes') }}"/>
                            <div class="clearfix"></div>
                            <div class="col-md-4 mb-3">
                                <x-form.input type="file" label="true" name="image" classes="imageInput" labelName="{{ trans('admin.attachment') }}"/>
                                <div class="img-card">
                                    <img class="img-fluid imagePreview" src="{{ get_full_image_url($purchase->image) }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin.partial.purchases.purchase_items')
            </div>
        </div>
    </form>
@endsection



