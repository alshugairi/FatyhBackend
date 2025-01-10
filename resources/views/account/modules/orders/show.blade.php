@extends('account.layouts.app')

@section('content')

    <div class="row mb-5">
        <div class="col-md-8">
            <h5 class="mb-3"><span class="fw-500">{{ trans('frontend.order_summary') }}:</span> #{{ $order->number }}</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>{{ trans('frontend.product') }}</th>
                        <th>{{ trans('frontend.quantity') }}</th>
                        <th>{{ trans('frontend.price') }}</th>
                        <th>{{ trans('frontend.total') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                @if ($item->product->image)
                                    <img class="rounded" src="{{ get_full_image_url($item->product->image) }}" alt="{{ $item->product->name }}" width="50" height="50">
                                @else
                                    <img class="rounded" src="//default image url" alt="{{ $item->product->name }}" width="50" height="50">
                                @endif
                                <span class="mx-2">{{ $item->name }}</span>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ format_currency($item->unit_price) }}</td>
                            <td>{{ format_currency($item->total) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-500">{{ trans('frontend.subtotal') }}</p>
                        <p class="mb-0 fw-500">{{ format_currency($order->subtotal) }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-500">{{ trans('frontend.tax') }}</p>
                        <p class="mb-0 fw-500">{{ format_currency($order->tax) }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-500">{{ trans('frontend.shipping_cost') }}</p>
                        <p class="mb-0 fw-500">{{ format_currency($order->shipping_cost) }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-500">{{ trans('frontend.discount') }}</p>
                        <p class="mb-0 fw-500">{{ format_currency($order->discount) }}</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p class="mb-0 fw-500">{{ trans('frontend.total') }}</p>
                        <h5 class="mb-0 fw-500">{{ format_currency($order->total) }}</h5>
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between mt-60">
                <button class="btn btn-danger print_receipt" data-id="{{ $order->id }}">{{ __('frontend.download_receipt') }}</button>
                <button class="btn btn-outline-danger">{{ __('frontend.cancel_order') }}</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded-25 p-4 mb-3">
                <h5  class="clearfix"><span class="float-start">{{ trans('frontend.order_id') }}:</span><span class="float-end">#{{ $order->number }}</span></h5>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.order_date') }}:</span> <span class="float-end">{{ $order->formatted_created_at }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.payment_status') }}:</span> <span class="float-end">{{ $order->payment_status }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.order_status') }}:</span> <span class="float-end">{!! \App\Enums\OrderStatus::getBadgeHtml($order->status) !!}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.payment_method') }}:</span> <span class="float-end">{{ $order->formatted_created_at }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.customer_name') }}:</span> <span class="float-end">{{ $order->customer_name }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.customer_phone') }}:</span> <span class="float-end">{{ $order->customer_phone }}</span></div>
            </div>
            <div class="border rounded-25 p-4 mb-3">
                <h5  class="clearfix"><span class="float-start">{{ trans('frontend.shipping_address') }}</span></h5>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.country') }}:</span> <span class="float-end">{{ $order->shipping_country }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.city') }}:</span> <span class="float-end">{{ $order->shipping_city }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.postal_code') }}:</span> <span class="float-end">{{ $order->shipping_postcode }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.address') }}:</span> <span class="float-end">{{ $order->shipping_address }}</span></div>
            </div>
            <div class="border rounded-25 p-4 mb-3">
                <h5  class="clearfix"><span class="float-start">{{ trans('frontend.billing_address') }}</span></h5>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.country') }}:</span> <span class="float-end">{{ $order->billing_country }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.city') }}:</span> <span class="float-end">{{ $order->billing_city }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.postal_code') }}:</span> <span class="float-end">{{ $order->billing_postcode }}</span></div>
                <div class="clearfix"><span class="fw-500 float-start">{{ trans('frontend.address') }}:</span> <span class="float-end">{{ $order->billing_address }}</span></div>
            </div>
        </div>
    </div>
@endsection
