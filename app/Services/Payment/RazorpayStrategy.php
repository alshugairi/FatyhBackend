<?php

namespace App\Services\Payment;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api as RazorpayAPI;

class RazorpayStrategy implements PaymentStrategyInterface
{
    private RazorpayAPI $razorpay;

    public function __construct()
    {
        $this->razorpay = new RazorpayAPI(
            config('razorpay.key_id'),
            config('razorpay.key_secret')
        );
    }

    public function processPayment(Order $order, array $config = []): array
    {
        try {
            $paymentLinkData = [
                'amount'          => $order->total * 100, // Convert to paisa
                'currency'        => config('razorpay.currency', 'INR'),
                'accept_partial'  => false,
                'description'     => "Payment for Order #{$order->id}",
                'customer'        => [
                    'name'    => $order->customer_name,
                    'email'   => $order->customer_email,
                    'contact' => $order->customer_phone ?? '',
                ],
                'notify'         => [
                    'sms'   => true,
                    'email' => true
                ],
                'reminder_enable' => true,
                'notes'          => [
                    'order_id' => $order->id,
                    'source'   => 'Shopifyze ' . app()->version() . ' - Razorpay API'
                ],
                'callback_url'   => route('payment.razorpay.callback', ['order' => $order->id]),
                'callback_method' => 'get'
            ];

            // Create payment link
            $paymentLink = $this->razorpay->paymentLink->create($paymentLinkData);

            $order->update([
                'status' => OrderStatus::PENDING_PAYMENT->value,
                'payment_status' => PaymentStatus::PENDING->value,
                'payment_transaction_id' => $paymentLink->id
            ]);

            return [
                'success'  => true,
                'redirect' => $paymentLink->short_url,
                'message' => 'Redirecting to payment...',
                'payment_link_id' => $paymentLink->id
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Razorpay: '. $e->getMessage()
            ];
        }
    }

    public function verifyPayment(string $paymentLinkId): array
    {
        try {
            $paymentLink = $this->razorpay->paymentLink->fetch($paymentLinkId);

            // Check if payment is completed
            if ($paymentLink->status === 'paid') {
                // Get the payment ID from the payment link
                $payments = $paymentLink->payments();

                // Usually the last payment will be the successful one
                $lastPayment = end($payments);

                return [
                    'success' => true,
                    'data'    => [
                        'payment_id'     => $lastPayment->id,
                        'amount'         => $paymentLink->amount / 100, // Convert from paisa
                        'status'         => $paymentLink->status,
                        'payment_method' => $lastPayment->method ?? null,
                        'email'          => $paymentLink->customer->email,
                        'contact'        => $paymentLink->customer->contact,
                        'created_at'     => $paymentLink->created_at,
                        'paid_at'        => $paymentLink->updated_at
                    ]
                ];
            }

            return [
                'success' => false,
                'message' => 'Payment is not completed. Current status: ' . $paymentLink->status
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay Verification Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ];
        }
    }

    public function cancelPaymentLink(string $paymentLinkId): array
    {
        try {
            $paymentLink = $this->razorpay->paymentLink->fetch($paymentLinkId);
            $paymentLink->cancel();

            return [
                'success' => true,
                'message' => 'Payment link cancelled successfully'
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay Cancel Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to cancel payment link: ' . $e->getMessage()
            ];
        }
    }
}
