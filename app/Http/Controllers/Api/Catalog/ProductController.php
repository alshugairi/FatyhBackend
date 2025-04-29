<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\Catalog\ProductDetailsResource,
    Http\Resources\Catalog\ProductResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Services\Catalog\BrandService,
    Services\Catalog\ProductService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service)
    {
    }

    public function show($id): Response
    {
        $product = $this->service->find(id: $id, relations: ['business','images', 'userWishlist', 'variants.attributeOptions.attribute']);

        if (!$product) {
            return Response::error(
                message: __(key:'share.product_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new ProductResource($product)
        );
    }
}
