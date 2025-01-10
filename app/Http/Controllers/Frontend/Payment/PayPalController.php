<?php

namespace App\Http\Controllers\Frontend\Payment;

use App\{Http\Controllers\Controller};
use Illuminate\{Http\Request, Support\Facades\Log};
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function success(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                return view('frontend.modules.payment.success', compact('response'));
            }

            if (isset($response['error']) && $response['error']['name'] == 'COMPLIANCE_VIOLATION') {
                $errorDetails = $response['error']['details'][0]['description'] ?? 'There was an issue with your payment. Please contact customer support.';
                return view('frontend.modules.payment.failed', compact('errorDetails'));
            }

            return view('frontend.modules.payment.failed', compact('response'));
        } catch (\Exception $e) {
            Log::error('PayPal Payment Processing Error: ' . $e->getMessage());
            return view('frontend.modules.payment.failed', ['errorDetails' => 'An error occurred while processing your payment. Please try again later.']);
        }
    }

    public function cancel()
    {
        return view('frontend.modules.payment.failed');
    }
}
