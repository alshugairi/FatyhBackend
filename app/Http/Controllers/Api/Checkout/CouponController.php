<?php

namespace App\Http\Controllers\Api\Checkout;

use App\{Http\Controllers\Controller,
    Http\Resources\CartResource,
    Http\Resources\CouponResource,
    Services\Sales\CouponService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};

class CouponController extends Controller
{
    public function __construct(private readonly CouponService $couponService)
    {
    }

    public function getByCode($code)
    {
        $coupon = $this->couponService->getByCode(code: $code);

        if (!$coupon) {
            return Response::error(
                message: __(key:'share.coupon_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new CouponResource($coupon),
        );
    }
}
