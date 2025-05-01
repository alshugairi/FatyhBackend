<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\BusinessResource,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\Catalog\ProductDetailsResource,
    Http\Resources\Catalog\ProductResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Pipelines\Catalog\ProductFilterPipeline,
    Services\BusinessService,
    Services\Catalog\BrandService,
    Services\Catalog\ProductService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $service,
                                private readonly BusinessService $businessService)
    {
    }

    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ProductResource::collection($this->service->index(filters: [
                    new ProductFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value])),
               ],
                relations: ['business','images', 'userWishlist', 'variants.attributeOptions.attribute']))
        );
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

    public function extraData($id)
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: [
                'similar_products' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 4)),
                'top_rated_products' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 4)),
            ]
        );
    }

    public function discover(Request $request): Response
    {
        $business = $request->filled('b') ? $this->businessService->find(id: $request->b) : null;

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: [
                'business' => new BusinessResource($business),
            ]
        );
    }
}
