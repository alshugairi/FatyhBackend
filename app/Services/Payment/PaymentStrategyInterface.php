<?php

namespace App\Services\Payment;

use App\Models\Order;

interface PaymentStrategyInterface
{
    public function processPayment(Order $order, array $config = []): array;
}
