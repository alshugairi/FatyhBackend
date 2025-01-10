<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class KashierStrategyOld implements PaymentStrategyInterface
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://checkout.kashier.io/payment';
        $this->apiUrl = 'https://api.kashier.io';
    }

    public function processPayment(Order $order, array $config = []): array
    {
        try {
            $paymentData = [
                'amount' => $order->total,
                'currency' => config('kashier.currency', 'EGP'),
                'order_id' => $order->id,
                'redirect_back' => route('payment.kashier.callback', ['order' => $order->id]),
                'display_lang' => app()->getLocale(),
                'merchantId' => config('kashier.merchant_id'),
                'customer_email' => $order->customer_email,
                'customer_name' => $order->customer_name,
                'allowedMethods' => $config['allowed_methods'] ?? ['card'],
                'source' => 'Shopifyze ' . app()->version() . ' - Kashier API'
            ];

            $hash = hash_hmac('sha256',
                json_encode($paymentData),
                config('kashier.api_key')
            );

            $paymentData['hash'] = $hash;

            $order->update([
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_transaction_id' => $order->id . '-' . time()
            ]);

            return [
                'success' => true,
                'redirect' => "{$this->baseUrl}/form",
                'message' => 'Redirecting to payment...',
                'payload' => $paymentData
            ];
        } catch (\Exception $e) {
            Log::error('Kashier Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Kashier: Payment processing failed. Please try again.'
            ];
        }
    }

    public function verifyPayment(string $paymentId): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('kashier.api_key'),
            ])->get("{$this->baseUrl}/api/v1/payments/{$paymentId}");

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'data' => $data
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment verification failed'
            ];
        } catch (\Exception $e) {
            Log::error('Kashier Verification Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment verification failed'
            ];
        }
    }
}
