<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\{Enums\OrderStatus,
    Enums\PaymentStatus,
    Http\Controllers\Controller,
    Models\Order,
    Services\Payment\RazorpayStrategy};
use Illuminate\{Http\Request, Support\Facades\Log};
use MyFatoorah\Library\API\Payment\MyFatoorahPaymentStatus;
use Exception;

class RazorpayController extends Controller
{
    public function success(Request $request,Order $order, RazorpayStrategy $razorpayStrategy)
    {
        try {
            $verification = $razorpayStrategy->verifyPayment($order->payment_transaction_id);

            if ($verification['success']) {
                $order->update([
                    'status' => OrderStatus::PAYMENT_CONFIRMED->value,
                    'payment_status' => PaymentStatus::PAID->value,
                    'payment_id' => $request->payment_transaction_id,
                    'payment_details' => $verification['data']
                ]);

                return view('frontend.modules.payment.success');
            }

          return view('frontend.modules.payment.success');
        } catch (Exception $ex) {
            return view('frontend.modules.payment.failed', ['errorDetails' => $ex->getMessage()]);
        }
    }

    public function cancel(Order $order, RazorpayStrategy $razorpayStrategy)
    {
        if ($order->payment_transaction_id) {
            $razorpayStrategy->cancelPaymentLink($order->payment_transaction_id);
        }

        $order->update([
            'status' => OrderStatus::CANCELED->value,
        ]);

        return redirect()->route('order.cancelled', $order);
    }
}
