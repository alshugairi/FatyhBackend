<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\Catalog\ProductDetailesResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Services\Catalog\BrandService,
    Services\Catalog\ProductService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service)
    {
    }
    public function show($id): Response
    {
        $product = $this->service->find($id);

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new ProductDetailesResource($product)
        );
    }
}
