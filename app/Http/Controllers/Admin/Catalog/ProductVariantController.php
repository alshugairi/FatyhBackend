<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Catalog\ProductVariantRequest;
use App\Models\Product;
use App\Services\Catalog\ProductVariantService;
use App\Utils\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;

class ProductVariantController extends Controller
{
    public function __construct(private readonly ProductVariantService $service)
    {
    }

    public function getProductVariants(Product $product): JsonResponse
    {
        $variants = $product->variants()
            ->with(['attributeOptions'])
            ->get()
            ->map(function($variant) {
                return [
                    'id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'sku' => $variant->sku,
                    'purchase_price' => $variant->purchase_price,
                    'stock_quantity' => $variant->stock_quantity,
                    'name' => $variant->attributeOptions->map(function($opt) { return $opt->name; })->join(' | ')
                ];
            });

        return response()->json($variants);
    }

    public function store(ProductVariantRequest $request, Product $product): Response
    {
        $data = $request->validated();
        $data['product_id'] = $product->id;

        $variant = $this->service->create($data);

        return Response::response(
            message: __('admin.created_successfully', ['module' => __('admin.variant')]),
            data: $variant->load('attributeOptions')
        );
    }

    public function destroy(int $id): Response
    {
        $this->service->delete($id);
        return Response::response(
            message: __('admin.deleted_successfully', ['module' => __('admin.variant')])
        );
    }
}
