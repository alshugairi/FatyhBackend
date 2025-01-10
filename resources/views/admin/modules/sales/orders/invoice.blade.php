<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
<head>
    <meta charset="UTF-8">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            max-width: 80mm;
            margin: 0 auto;
            padding: 10px;
            background: white;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #6B46C1;
            margin-bottom: 5px;
        }

        .company-address, .company-phone {
            font-size: 12px;
            color: #666;
            margin: 3px 0;
        }

        .order-info {
            border-top: 1px dashed #ddd;
            border-bottom: 1px dashed #ddd;
            padding: 8px 0;
            margin: 10px 0;
            font-size: 12px;
        }

        .items-table {
            width: 100%;
            font-size: 12px;
            margin: 10px 0;
            border-collapse: collapse;
        }

        .items-table th {
            text-align: left;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }

        .items-table td {
            padding: 5px 0;
        }

        .items-table .qty {
            width: 40px;
        }

        .items-table .price {
            text-align: right;
        }

        .summary {
            border-top: 1px dashed #ddd;
            padding-top: 10px;
            margin-top: 10px;
            font-size: 12px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .total-row {
            font-weight: bold;
            margin-top: 10px;
        }

        .payment-info {
            margin: 15px 0;
            font-size: 12px;
            display: flex;
            justify-content: space-between;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }

        .thank-you {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .footer-text {
            color: #666;
            font-size: 10px;
            margin-top: 10px;
        }
    </style>
    @if(app()->getLocale() === 'ar')
        <link rel="stylesheet" href="{{ asset('assets/admin') }}/css/rtl.css">
        <style>
            .items-table th {
                text-align: right !important;
            }
        </style>
    @endif
</head>
<body>
<div class="invoice-container">
    <div class="header">
        <div class="company-name">{{ $settings->where('key', 'company_name')->first()?->value }}</div>
        <div class="company-address">{{ $settings->where('key', 'company_address')->first()?->value }}</div>
        <div class="company-phone">Tel: {{ $settings->where('key', 'company_phone')->first()?->value }}</div>
    </div>

    <div class="order-info">
        <div>{{ __('admin.order_id') }}: #{{ $order->number }}</div>
        <div>{{ __('admin.date') }}: {{ $order->formatted_created_at }}</div>
    </div>

    <table class="items-table">
        <thead>
        <tr>
            <th class="qty">{{ __('admin.qty') }}</th>
            <th>{{ __('admin.description') }}</th>
            <th class="price">{{ __('admin.price') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
        <tr>
            <td class="qty">{{ $item->quantity }}</td>
            <td>{{ $item->product?->name }}</td>
            <td class="price" dir="ltr">{{ format_currency($item->unit_price) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3" style="font-size: 11px; color: #666;">VAT-14 (14%)</td>
        </tr>
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <span>{{ __('admin.subtotal') }}:</span>
            <span dir="ltr">{{ format_currency($order->subtotal) }}</span>
        </div>
        <div class="summary-row">
            <span>{{ __('admin.tax_fee') }}:</span>
            <span dir="ltr">{{ format_currency($order->tax) }}</span>
        </div>
        <div class="summary-row">
            <span>{{ __('admin.discount') }}:</span>
            <span dir="ltr">{{ format_currency($order->discount) }}</span>
        </div>
        <div class="summary-row total-row">
            <span>{{ __('admin.total') }}:</span>
            <span dir="ltr">{{ format_currency($order->total) }}</span>
        </div>
    </div>

    <div class="payment-info">
        <span>{{ __('admin.payment_type') }}:</span>
        <span>{{ __('admin.cash') }}</span>
    </div>

    <div class="footer">
        <div class="thank-you">{{ __('admin.thank_you') }}</div>
    </div>
</div>
</body>
</html>
