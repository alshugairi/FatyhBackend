<?php

namespace App\Http\Controllers\Admin\Sales;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Sales\CouponRequest,
    Models\Coupon,
    Services\Sales\CouponService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * @param CouponService $service
     */
    public function __construct(private readonly CouponService $service)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.modules.sales.coupons.index', get_defined_vars());
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.modules.sales.coupons.create', get_defined_vars());
    }

    /**
     * @param CouponRequest $request
     * @return RedirectResponse
     */
    public function store(CouponRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'sales/coupons');
        $this->service->create(data: $data);
        flash(__('admin.created_successfully', ['module' => __('admin.coupon')]))->success();
        return redirect()->route(route: 'admin.coupons.index');
    }

    /**
     * @param Coupon $coupon
     * @return View
     */
    public function edit(Coupon $coupon): View
    {
        return view('admin.modules.sales.coupons.edit', get_defined_vars());
    }

    /**
     * @param CouponRequest $request
     * @param Coupon $coupon
     * @return RedirectResponse
     */
    public function update(CouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $data = $request->validated();
        $data = upload_file($data, 'image', 'sales/coupons', $coupon->image);
        $this->service->update(data: $data, id: $coupon->id);
        flash(__('admin.updated_successfully', ['module' => __('admin.coupon')]))->success();
        return redirect()->route(route: 'admin.coupons.index');
    }

    /**
     * @param Coupon $coupon
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Coupon $coupon): RedirectResponse
    {
        $this->service->delete(id: $coupon->id);
        flash(__('admin.coupon').' '.__('admin.deleted_successfully'))->success();
        return back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function list(Request $request): JsonResponse
    {
        return $this->service->list();
    }
}
