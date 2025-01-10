<?php

namespace App\Http\Controllers\Frontend;

use App\{Enums\PlatformType,
    Http\Controllers\Controller,
    Http\Requests\Frontend\OrderRequest,
    Models\City,
    Models\Country,
    Models\Order,
    Models\Product,
    Services\Payment\PaymentService,
    Services\Sales\OrderService};
use Illuminate\{Contracts\View\View, Http\Request, Support\Facades\DB};
use Exception;

class CheckoutController extends Controller
{
    public function __construct(private readonly OrderService $orderService,
                                private readonly PaymentService $paymentService)
    {
    }

    public function index(): View
    {
        $cartItems = \Cart::getContent();
        $cartTotal = \Cart::getTotal();
        $countries = Country::getAll();
        $cities = City::getAll();

        return view('frontend.modules.checkout', get_defined_vars());
    }

    public function placeOrder(OrderRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $data['subtotal'] = \Cart::getSubtotal();
            $data['total'] = \Cart::getTotal();
            $order = $this->orderService->placeOrder($data);

            $paymentResult = $this->paymentService->processPayment(order: $order, paymentMethod: $request->payment_method);

            if (!$paymentResult['success']) {
                DB::rollBack();
                return $this->handleErrorResponse($paymentResult);
            }
            DB::commit();

            \Cart::clear();

            return $this->handleSuccessResponse($paymentResult);

        } catch (Exception $e) {
            DB::rollBack();
            \Log::error('Order placement failed: ' . $e->getMessage());
        }
    }

    private function handleSuccessResponse(array $paymentResult)
    {
        if (isset($paymentResult['redirect'])) {
            return redirect()->away($paymentResult['redirect']);
        }

        return redirect()->route('order.confirmation')
            ->with('success', $paymentResult['message']);
    }

    private function handleErrorResponse(array $error)
    {
        return redirect()->back()
            ->withInput()
            ->with('error', $error['message']);
    }

}
