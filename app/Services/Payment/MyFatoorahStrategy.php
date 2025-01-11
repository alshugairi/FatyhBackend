<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use MyFatoorah\Library\API\Payment\MyFatoorahPayment;

class MyFatoorahStrategy implements PaymentStrategyInterface
{
    public function processPayment(Order $order, array $config = []): array
    {
        $mfConfig = [
            'apiKey'      => config('myfatoorah.api_key'),
            'isTest'      => config('myfatoorah.test_mode'),
            'countryCode' => config('myfatoorah.country_iso'),
        ];
        try {
            $paymentData = [
                'CustomerName'       => $order->customer_name,
                'InvoiceValue'       => $order->total,
                'DisplayCurrencyIso' => config('myfatoorah.currency_iso'),
                'CustomerEmail'      => $order->customer_email,
                'CallBackUrl'        => route('payment.myfatoorah.success', ['order' => $order->id]),
                'ErrorUrl'           => route('payment.myfatoorah.cancel', ['order' => $order->id]),
                'MobileCountryCode'  => '',
                'CustomerMobile'     => '',
                'Language'           => app()->getLocale(),
                'CustomerReference'  => $order->id,
                'SourceInfo'         => 'Fatyh ' . app()->version() . ' - MyFatoorah API'
            ];

            $myFatoorah = new MyFatoorahPayment($mfConfig);
            $response = $myFatoorah->getInvoiceURL($paymentData);

            $order->update([
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_transaction_id' => $response['invoiceId']
            ]);

            return [
                'success' => true,
                'redirect' => $response['invoiceURL'],
                'message' => 'Redirecting to payment...',
            ];
        } catch (\Exception $e) {
            Log::error('MyFatoorah Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'MyFatoorah: Payment processing failed. Please try again.'
            ];
        }
    }
}
