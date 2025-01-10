@extends('account.layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ trans('frontend.my_orders') }}</h4>
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
    {{ $orders->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-5') }}
@endsection

