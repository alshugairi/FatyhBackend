<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            font-size: 14px;
            line-height: 24px;
        }
        .header {
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .company-info {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        .totals {
            text-align: right;
            margin-top: 20px;
        }
        .totals div {
            margin: 5px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #777;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <div class="header">
        <div style="float: left;">
            <h2>INVOICE</h2>
            <div>Invoice #: {{ $order->number }}</div>
            <div>Date: {{ $order->created_at->format('M d, Y') }}</div>
        </div>
        <div class="company-info">
            <h2>Your Company Name</h2>
            <div>123 Business Street</div>
            <div>City, State 12345</div>
            <div>Phone: (123) 456-7890</div>
            <div>Email: info@yourcompany.com</div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div style="margin-bottom: 20px;">
        <h3>Bill To:</h3>
        <div>{{ $order->customer_name }}</div>
        @if($order->customer_email)
            <div>Email: {{ $order->customer_email }}</div>
        @endif
        @if($order->customer_phone)
            <div>Phone: {{ $order->customer_phone }}</div>
        @endif
        @if($order->billing_address)
            <div>{{ $order->billing_address }}</div>
            <div>{{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_postcode }}</div>
            <div>{{ $order->billing_country }}</div>
        @endif
    </div>

    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->unit_price, 2) }}</td>
                <td>₹{{ number_format($item->total, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div>Subtotal: ₹{{ number_format($order->subtotal, 2) }}</div>
        <div>Tax (18%): ₹{{ number_format($order->tax, 2) }}</div>
        @if($order->discount > 0)
            <div>Discount: -₹{{ number_format($order->discount, 2) }}</div>
        @endif
        <div><strong>Total: ₹{{ number_format($order->total, 2) }}</strong></div>
    </div>

    <div class="footer">
        Thank you for your business!
    </div>

    <div class="no-print" style="margin-top: 20px; text-align: center;">
        <button onclick="window.print();" style="padding: 10px 20px;">Print Invoice</button>
    </div>
</div>
</body>
</html>
