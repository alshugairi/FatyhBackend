@extends('account.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ trans('frontend.overview') }}</h4>
        <div>{{ trans('frontend.welcome_back') }}, {{ auth()->user()->name }}!</div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card shadow-sm bg-info text-white p-3 rounded">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-shopping-cart"></i> {{ trans('frontend.total_orders') }}
                </h6>
                <h3 class="mb-0">{{ $orderCounts->total_orders }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card shadow-sm bg-success text-white p-3 rounded">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-check-circle"></i> {{ trans('frontend.total_completed') }}
                </h6>
                <h3 class="mb-0">{{ $orderCounts->delivered_orders }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card shadow-sm bg-danger text-white p-3 rounded">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-undo"></i> {{ trans('frontend.total_returned') }}
                </h6>
                <h3 class="mb-0">{{ $orderCounts->returned_orders }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card shadow-sm bg-warning text-dark p-3 rounded">
                <h6 class="text-muted mb-3">
                    <i class="fas fa-wallet"></i> {{ trans('frontend.wallet_balance') }}
                </h6>
                <h3 class="mb-0">{{ format_currency(auth()->user()->wallet) }}</h3>
            </div>
        </div>
    </div>



    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">{{ trans('frontend.latest_orders') }}</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>{{ __('frontend.order_id') }}</th>
                <th>{{ __('frontend.date') }}</th>
                <th>{{ __('frontend.status') }}</th>
                <th>{{ __('frontend.payment_status') }}</th>
                <th>{{ __('frontend.amount') }}</th>
                <th>{{ __('frontend.products') }}</th>
                <th>{{ __('frontend.actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->number }}</td>
                    <td>{{ format_datetime($order->created_at) }}</td>
                    <td>{!! \App\Enums\OrderStatus::getBadgeHtml($order->status) !!}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>{{ format_currency($order->total) }}</td>
                    <td>{{ $order->items_count }} {{ __('frontend.product') }}</td>
                    <td><a href="{{ route('account.orders.show', $order->id) }}" class="btn btn-success btn-xs rounded-2"><i class="fas fa-eye"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

