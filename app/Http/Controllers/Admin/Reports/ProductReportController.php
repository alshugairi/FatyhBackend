<?php

namespace App\Http\Controllers\Admin\Reports;

use App\{Enums\OrderStatus,
    Http\Controllers\Controller,
    Models\Order,
    Pipelines\Catalog\ProductFilterPipeline,
    Services\Catalog\ProductService};
use Exception;
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse};
use Illuminate\Http\Request;

class ProductReportController extends Controller
{
    public function __construct(private readonly ProductService $service)
    {
    }

    public function products(Request $request)
    {
        return view('admin.modules.reports.products', get_defined_vars());
    }

    public function productsList(Request $request): JsonResponse
    {
        return $this->service->soldQuantityList(filters: [
            new ProductFilterPipeline(request: $request),
        ]);
    }
}
