@extends('admin.layouts.app')

@section('content')
    <form action="{{ route('admin.products.store') }}" method="post" enctype="multipart/form-data" id="submitForm">
        @method('post')
        @csrf
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="page-title">{{ __('admin.create') }} {{ __('admin.product') }}</h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <x-datatable.save module="{{ __('admin.product') }}"/>
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
                                                      value="{{ old('name.'.$appLanguage->code) }}"
                                                      label="true" labelName="{{ __('admin.name') }}"/>

                                        <x-form.input type="text" name="short_description[{{ $appLanguage->code }}]"
                                                      key="id-short_description-{{ $appLanguage->code }}"
                                                      value="{{ $product->getTranslation('short_description', $appLanguage->code) }}"
                                                      value="{{ old('short_description.'.$appLanguage->code) }}"
                                                      label="true" labelName="{{__('admin.short_description') }}"/>

                                        <div class="col-12 mb-3">
                                            <label class="form-label">{{ __('admin.description') }}</label>
                                            <textarea class="form-control quill-editor"
                                                      id="description_{{ $appLanguage->code }}"
                                                      name="description[{{ $appLanguage->code }}]"
                                                      style="display: none;">{{ old('description.'.$appLanguage->code) }}</textarea>
                                            <div id="editor_description_{{ $appLanguage->code }}"
                                                 class="quill-container">{!! old('description.'.$appLanguage->code) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </x-layouts.language-tabs>
                        <div class="row">
                            <x-form.input col="col-md-4" type="text" label="true" name="sku" required="true" labelName="{{ trans('admin.sku') }}"/>
                            <x-form.input col="col-md-4" type="text" label="true" name="barcode" required="true" labelName="{{ trans('admin.barcode') }}"/>
                            <x-form.input col="col-md-4" type="number" step="any" label="true" name="sell_price" required="true" labelName="{{ trans('admin.sell_price') }}"/>
                            <x-form.input col="col-md-4" type="number" step="any" label="true" name="purchase_price" required="true" labelName="{{ trans('admin.purchase_price') }}"/>
                            <x-form.select col="col-md-4" label="true" name="category_id" :options="$categories" labelName="{{ trans('admin.category') }}"/>
                            <x-form.select col="col-md-4" label="true" name="brand_id" :options="$brands" labelName="{{ trans('admin.brand') }}"/>
                            <x-form.switch col="col-md-4" label="true" name="status" value="1" labelName="{{ trans('admin.active') }}"/>
                            <x-form.switch col="col-md-4" label="true" name="stock_quantity" value="1" labelName="{{ trans('admin.stock_quantity') }}"/>
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

@push('scripts')
    <script>
        $('#submitForm').on('submit', function(e) {
            $('.quill-editor').each(function() {
                const textareaId = $(this).attr('id');
                $(this).val(quillEditors[textareaId].root.innerHTML);
            });
        });
    </script>
@endpush

