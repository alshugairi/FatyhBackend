<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\{Enums\OrderStatus,
    Enums\PaymentStatus,
    Http\Controllers\Controller,
    Models\Order,
    Services\Payment\KashierStrategy};
use Illuminate\{Http\RedirectResponse, Http\Request, Support\Facades\DB, Support\Facades\Log, View\View};
use Exception;

class KashierController extends Controller
{
    public function handleSuccess(Request $request, Order $order, KashierStrategy $kashier): View
    {
        try {
            if (!$kashier->verifySignature($request)) {
                return $this->handlePaymentFailure($order,'Invalid payment signature');
            }

            if ($order->payment_status === PaymentStatus::PAID->value) {
                return view('frontend.modules.payment.failed', ['errorDetails' => 'Payment was already paid']);
            }
            if ($order->payment_status === PaymentStatus::FAILED->value) {
                return view('frontend.modules.payment.failed', ['errorDetails' => 'Payment was already failed']);
            }
            if ($order->payment_status === PaymentStatus::REFUNDED->value) {
                return view('frontend.modules.payment.failed', ['errorDetails' => 'Payment was already refunded']);
            }

            return DB::transaction(function () use ($order, $request) {
                if ($request->paymentStatus === 'SUCCESS') {

                    $order->update([
                        'status' => OrderStatus::PAYMENT_CONFIRMED->value,
                        'payment_status' => PaymentStatus::PAID->value,
                        'paid_at' => now(),
                        'payment_details' => $request->all()
                    ]);

                    return view('frontend.modules.payment.success');
                }

                $order->update([
                    'status' => OrderStatus::PAYMENT_FAILED->value,
                    'payment_status' => PaymentStatus::FAILED->value,
                    'payment_details' => $request->all()
                ]);

                return view('frontend.modules.payment.failed');
            });
        } catch (\Exception $e) {
            return view('frontend.modules.payment.failed', ['errorDetails' => $e->getMessage()]);
        }
    }

    private function handlePaymentFailure(Order $order,string $message,PaymentStatus $status = PaymentStatus::FAILED): View
    {
        $order->update([
            'status' => OrderStatus::PAYMENT_FAILED->value,
            'payment_status' => $status->value,
            'payment_details' => json_encode([
                'error_message' => $message,
                'failed_at' => now()->toIso8601String()
            ])
        ]);

        return view('frontend.modules.payment.failed', ['errorDetails' => $message]);
    }

    public function handleFailure(Request $request, Order $order): View
    {
        try {
            $order->update([
                'status' => OrderStatus::PAYMENT_FAILED->value,
                'payment_status' => PaymentStatus::FAILED->value,
                'payment_details' => json_encode($request->all())
            ]);
            return view('frontend.modules.payment.failed');

        } catch (\Exception $e) {
            return view('frontend.modules.payment.failed', ['errorDetails' => $e->getMessage()]);
        }
    }

    public function handleWebhook(Request $request)
    {
        try {
            if (!$this->verifyWebhookSignature($request)) {
                Log::warning('Kashier Webhook: Invalid signature', [
                    'payload' => $request->all()
                ]);
                return response()->json(['status' => 'error', 'message' => 'Invalid webhook signature'], 403);
            }

            Log::info('Kashier Webhook Received', [
                'payload' => $request->all()
            ]);

            $paymentData = $request->all();
            $orderId = $paymentData['orderId'] ?? null;
            $paymentStatus = $paymentData['status'] ?? 'FAILED';

            $order = Order::findOrFail($orderId);

            return DB::transaction(function () use ($order, $paymentData, $paymentStatus) {
                switch ($paymentStatus) {
                    case 'CAPTURED':
                        $order->update([
                            'status' => OrderStatus::PAYMENT_CONFIRMED->value,
                            'payment_status' => PaymentStatus::PAID->value,
                            'paid_at' => now(),
                            'payment_details' => json_encode($paymentData)
                        ]);
                        break;

                    case 'FAILED':
                        $order->update([
                            'status' => OrderStatus::PAYMENT_FAILED->value,
                            'payment_status' => PaymentStatus::FAILED->value,
                            'payment_details' => json_encode($paymentData)
                        ]);
                        break;

                    default:
                        Log::warning('Kashier Webhook: Unexpected status', [
                            'order_id' => $order->id,
                            'status' => $paymentStatus
                        ]);
                }
                return response()->json(['status' => 'success']);
            });
        } catch (\Exception $e) {
            Log::error('Kashier Webhook Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);

            return response()->json(['status' => 'error', 'message' => 'Webhook processing failed'], 500);
        }
    }
}
