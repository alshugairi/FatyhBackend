<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Pipelines\Settings\SettingsFilterPipeline;
use App\Services\Settings\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public function processPayment(Order $order, string $paymentMethod): array
    {
        try {
            $strategy = PaymentFactory::createPaymentStrategy(paymentMethod:$paymentMethod);
            return $strategy->processPayment(order: $order, config: $this->getPaymentConfig());
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment processing failed. Please try again.'
            ];
        }
    }

    public function getPaymentConfig(): array
    {
        $paymentSettings = app(SettingsService::class)->getAll(filters: [ new SettingsFilterPipeline(new Request(['prefix' => 'payment']))]);
        return $paymentSettings->pluck('value','key')->toArray();
    }
}
