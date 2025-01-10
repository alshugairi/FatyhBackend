<?php

namespace App\Services\Payment;

use App\Models\Order;

class CashOnDeliveryStrategy implements PaymentStrategyInterface
{
    public function processPayment(Order $order): array
    {
        $order->update([
            'payment_status' => 'pending',
            //'status' => 'processing'
        ]);

        return [
            'success' => true,
            'redirect' => route('order.confirmation', $order->id),
            'message' => 'Order placed successfully!'
        ];
    }
}
