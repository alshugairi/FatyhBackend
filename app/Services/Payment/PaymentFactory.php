<?php

namespace App\Services\Payment;

class PaymentFactory
{
    public static function createPaymentStrategy(string $paymentMethod): PaymentStrategyInterface
    {
        return match ($paymentMethod) {
            'cash_on_delivery' => new CashOnDeliveryStrategy(),
            'stripe' => new StripeStrategy(),
            'paypal' => new PayPalStrategy(),
            'myfatoorah' => new MyFatoorahStrategy(),
            'kashier' => new KashierStrategy(),
            'razorpay' => new RazorpayStrategy(),
            default => throw new \InvalidArgumentException('Invalid payment method')
        };
    }
}
