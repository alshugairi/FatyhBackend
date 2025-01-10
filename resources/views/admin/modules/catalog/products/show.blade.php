@extends('admin.layouts.app')

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="page-title">{{ __('admin.product_details') }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    @include('admin.partial.products.sidebar')
                </div>
                <div class="col-lg-9 col-md-6 col-sm-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- Information Tab -->
                        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="v-pills-info-tab">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h3 class="card-title">{{ __('admin.information') }}</h3>
                                    <div class="card-tools">
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.name') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ $product->name }}</span></div>

                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.sku') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ $product->sku }}</span></div>

                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.barcode') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ $product->barcode }}</span></div>

                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.sell_price') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ format_currency($product->sell_price) }}</span></div>

                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.purchase_price') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ format_currency($product->purchase_price) }}</span></div>

                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.category') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ $product->category?->name }}</span></div>

                                        <div class="col-md-3 mb-3"><span class="fw-bold">{{ __('admin.brand') }}</span></div>
                                        <div class="col-md-3 mb-3"><span class="text-muted">{{ $product->brand?->name }}</span></div>

                                        <div class="clearfix"></div>
                                        <div class="col-md-3 mb-3">
                                            <span class="fw-bold">{{ __('admin.image') }}</span>
                                            @if(!empty($product->image))
                                                <div class="img-card mt-2">
                                                    <img class="img-fluid imagePreview" src="{{ get_full_image_url($product->image) }}">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('admin.partial.products.tab_variation')
                        @include('admin.partial.products.tab_gallery')
                        @include('admin.partial.products.tab_videos')
                        @include('admin.partial.products.tab_seo')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


