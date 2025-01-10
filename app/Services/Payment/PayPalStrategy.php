<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Exception;

class PayPalStrategy implements PaymentStrategyInterface
{
    public function processPayment(Order $order, array $config = []): array
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();

            $paypalOrder = $provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => 'USD',
                            'value' => $order->total
                        ],
                        'reference_id' => $order->id
                    ]
                ],
                'application_context' => [
                    'return_url' => route('payment.paypal.success'),
                    'cancel_url' => route('payment.paypal.cancel'),
                ]
            ]);

            if (isset($paypalOrder['error'])) {
                Log::error('PayPal error: ' . $paypalOrder['error']['message']);
                throw new Exception('PayPal Error: ' . $paypalOrder['error']['message']);
            }

            $order->update([
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_session_id' => $paypalOrder['id']
            ]);

            $redirectUrl = '';
            foreach ($paypalOrder['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    $redirectUrl = $links['href'];
                }
            }

            return [
                'success' => true,
                'redirect' => $redirectUrl,
                'message' => 'Redirecting to PayPal...'
            ];
        } catch (Exception $e) {
            Log::error('Paypal payment processing failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
