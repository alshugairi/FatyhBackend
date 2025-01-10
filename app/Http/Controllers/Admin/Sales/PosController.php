<?php

namespace App\Http\Controllers\Admin\Sales;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Sales\CouponRequest,
    Models\Brand,
    Models\Category,
    Models\Coupon,
    Services\Sales\CouponService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class PosController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.modules.sales.pos.index', get_defined_vars());
    }
}
