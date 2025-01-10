<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class KashierStrategy implements PaymentStrategyInterface
{
    private string $baseUrl;
    private string $apiUrl;

    public function __construct()
    {
        $this->baseUrl = 'https://checkout.kashier.io';
        $this->apiUrl = 'https://api.kashier.io';
    }

    public function processPayment(Order $order, array $config = []): array
    {
        try {
            $paymentParams = [
                'merchantId' => config('kashier.merchant_id'),
                'orderId' => (string)$order->id,
                'amount' => $order->total,
                'currency' => config('kashier.currency', 'EGP'),
                'merchantRedirect' => route('payment.kashier.success', ['order' => $order->id]),
                'failureRedirect' => route('payment.kashier.failure', ['order' => $order->id]),
                'serverWebhook' => route('payment.kashier.webhook'),
                'hash' => $this->generateHash($order),
                'mode' => config('kashier.mode', 'test'),
                'allowedMethods' => implode(',', $config['allowed_methods'] ?? ['card']),
                'defaultMethod' => $config['default_method'] ?? 'card',
                'redirectMethod' => $config['redirect_method'] ?? 'GET',
                'manualCapture' => $config['manual_capture'] ?? false,
                'enable3DS' => $config['enable_3ds'] ?? true,
                'customer' => json_encode([
                    'reference' => $order->customer_email . '_' . $order->id,
                    'name' => $order->customer_name,
                    'email' => $order->customer_email,
                    'phone' => $order->customer_phone ?? '',
                ]),
                'metadata' => json_encode([
                    'reference' => Str::uuid(),
                    'user_id' => auth()->id() ?? null,
                ]),
                'display' => $config['display'] ?? 'en',
                'paymentRequestId' => Str::uuid()->toString(),
            ];

            $paymentParams = array_filter($paymentParams);

            $order->update([
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_id' => $paymentParams['paymentRequestId']
            ]);

            $paymentUrl = $this->baseUrl . '?' . http_build_query($paymentParams);

            return [
                'success' => true,
                'redirect' => $paymentUrl,
                'message' => 'Redirecting to payment...',
                'payload' => $paymentParams
            ];
        } catch (\Exception $e) {
            Log::error('Kashier Payment Processing Error', [
                'order_id' => $order->id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
                'error' => $e->getMessage()
            ];
        }
    }

    private function generateHash(Order $order): string
    {
        $mid = config('kashier.merchant_id');
        $amount = $order->total;
        $currency = 'EGP';
        $orderId = (string)$order->id;
        $secret = config('kashier.api_key');

        $path = "/?payment=".$mid.".".$orderId.".".$amount.".".$currency;
        return hash_hmac( 'sha256' , $path , $secret ,false);
    }

    public function verifySignature(Request $request): bool
    {
        $queryString = collect($request->query())
            ->except(['signature', 'mode'])
            ->map(fn($value, $key) => "$key=$value")
            ->implode('&');

        $signature = hash_hmac(
            'sha256',
            $queryString,
            config('kashier.api_key'),
            false
        );

        return hash_equals($signature, $request->query('signature', ''));
    }

    public function verifyWebhookSignature(Request $request): bool
    {
        $webhookSignature = $request->header('X-Kashier-Signature');
        $payload = $request->getContent();

        $expectedSignature = hash_hmac('sha256', $payload, config('kashier.webhook_secret'));

        return hash_equals($expectedSignature, $webhookSignature);
    }
}
