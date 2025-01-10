<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\{Enums\OrderStatus, Enums\PaymentStatus, Http\Controllers\Controller, Models\Order};
use Illuminate\{Http\Request, Support\Facades\Log};
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;

class MyFatoorahController extends Controller
{
    public function success(Request $request)
    {
        try {
            $mfConfig = [
                'apiKey'      => config('myfatoorah.api_key'),
                'isTest'      => config('myfatoorah.test_mode'),
                'countryCode' => config('myfatoorah.country_iso'),
            ];

            $paymentId = $request->input('paymentId');

            $myFatoorah = new MyFatoorahPaymentStatus($mfConfig);
            $paymentData = $myFatoorah->getPaymentStatus($paymentId, 'PaymentId');

            $orderId = $paymentData->CustomerReference;
            $order = Order::findOrFail($orderId);

            if ($paymentData->InvoiceStatus == 'Paid') {
                $order->update([
                    'status' => OrderStatus::PAYMENT_CONFIRMED->value,
                    'payment_status' => PaymentStatus::PAID->value,
                    'payment_id' => $paymentId
                ]);
                return view('frontend.modules.payment.success');
            }

            return view('frontend.modules.payment.failed');
        } catch (Exception $ex) {
            return view('frontend.modules.payment.failed', ['errorDetails' => $ex->getMessage()]);
        }
    }

    public function cancel(Request $request)
    {
        try {
            $mfConfig = [
                'apiKey'      => config('myfatoorah.api_key'),
                'isTest'      => config('myfatoorah.test_mode'),
                'countryCode' => config('myfatoorah.country_iso'),
            ];

            $paymentId = $request->input('paymentId');

            $myFatoorah = new MyFatoorahPaymentStatus($mfConfig);
            $paymentData = $myFatoorah->getPaymentStatus($paymentId, 'PaymentId');

            $orderId = $paymentData->CustomerReference;
            $order = Order::findOrFail($orderId);

            $order->update([
                'status' => OrderStatus::PAYMENT_FAILED->value,
                'payment_status' => PaymentStatus::FAILED->value,
                'payment_id' => $paymentId,
            ]);

            return view('frontend.modules.payment.failed');
        } catch (Exception $ex) {
            return view('frontend.modules.payment.failed', ['errorDetails' => $ex->getMessage()]);
        }
    }
}
