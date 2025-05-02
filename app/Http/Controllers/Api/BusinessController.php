<?php

namespace App\Http\Controllers\Api;

use App\{Http\Controllers\Controller,
    Http\Resources\BusinessResource,
    Http\Resources\Catalog\CategoryResource,
    Http\Resources\Catalog\CollectionResource,
    Http\Resources\Catalog\ProductResource,
    Http\Resources\Catalog\ReviewResource,
    Pipelines\ReviewFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\BusinessService,
    Services\Catalog\CategoryService,
    Services\Catalog\CollectionService,
    Services\Catalog\ProductService,
    Services\ReviewService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};

class BusinessController extends Controller
{
    public function __construct(private readonly BusinessService $businessService,
                                private readonly ReviewService $reviewService)
    {
    }

    public function show(int $id): Response
    {
        $business = $this->businessService->find(id: $id);

        if (!$business) {
            return Response::error(
                message: __(key:'share.business_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new BusinessResource($business)
        );
    }

    public function fullData(int $id): Response
    {
        $business = $this->businessService->find(id: $id);

        if (!$business) {
            return Response::error(
                message: __(key:'share.business_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: [
                'business' => new BusinessResource($business),
                'business_products' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 12)),
                'categories' => CategoryResource::collection(app(CategoryService::class)->getAll(filters: [
                    new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc')
                ],limit: 3)),
                'collections' => CollectionResource::collection(app(CollectionService::class)->getAll(filters: [
                    new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc')
                ],limit: 6)),
            ]
        );
    }

    public function reviews(int $id): Response
    {
        $business = $this->businessService->find(id: $id);

        if (!$business) {
            return Response::error(
                message: __(key:'share.business_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: [
                'business' => new BusinessResource($business),
                'reviews' => ReviewResource::collection(
                    $this->reviewService->index(filters: [
                        new ReviewFilterPipeline(request: request()->merge(['business_id' => $business->id])),
                    ], paginate: 24)
                )
            ]
        );
    }
}
