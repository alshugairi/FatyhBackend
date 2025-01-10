<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class StripeStrategy implements PaymentStrategyInterface
{
    public function processPayment(Order $order, array $config = []): array
    {
        try {
            $stripe = new \Stripe\StripeClient($config['payment_stripe_secret']);

            $lineItems = [];
            foreach ($order->items as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item->product->name,
                            'images' => $item->product->image ? [get_full_image_url($item->product->image)] : [],
                        ],
                        'unit_amount' => (int)($item->unit_price * 100),
                    ],
                    'quantity' => $item->quantity,
                ];
            }

            $session = $stripe->checkout->sessions->create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order' => $order->id, 'session_id' => '{CHECKOUT_SESSION_ID}']),
                'cancel_url' => route('payment.cancel', ['order' => $order->id]),
                'customer_email' => $order->customer_email,
                'metadata' => [
                    'order_id' => $order->id,
                ],
                'payment_intent_data' => [
                    'metadata' => [
                        'order_id' => $order->id,
                    ],
                ],
            ]);

            $order->update([
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_session_id' => $session->id
            ]);

            return [
                'success' => true,
                'redirect' => $session->url,
                'message' => 'Redirecting to payment...'
            ];
        } catch (\Exception $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
