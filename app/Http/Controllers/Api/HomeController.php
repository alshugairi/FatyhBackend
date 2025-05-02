<?php

namespace App\Http\Controllers\Api;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\Catalog\CategoryResource,
    Http\Resources\Catalog\CollectionResource,
    Http\Resources\Catalog\ProductResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Pipelines\Catalog\CategoryFilterPipeline,
    Pipelines\Settings\PostFilterPipeline,
    Pipelines\SortFilterPipeline,
    Services\Catalog\BrandService,
    Services\Catalog\CategoryService,
    Services\Catalog\CollectionService,
    Services\Catalog\ProductService,
    Services\Settings\PostService,
    Utils\HttpFoundation\Response};

class HomeController extends Controller
{
    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: [
                'sliders' => CategoryResource::collection(app(PostService::class)->getAll(filters: [
                    new PostFilterPipeline(request: request()->merge(['type' => 'slider'])),
                ])),
                'categories' => CategoryResource::collection(app(CategoryService::class)->getAll(filters: [
                    new CategoryFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value, 'is_featured' => 1])),
                ])),
                'brands' => BrandResource::collection(app(BrandService::class)->getAll(filters: [
                    new BrandFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value, 'is_featured' => 1])),
                ])),
                'popular_products' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 4)),
                'best_sellers' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 4)),
            ]
        );
    }

    public function extraHome(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: [
                'flash_sale' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 4)),
                'top_rated' => ProductResource::collection(app(ProductService::class)->getAll(filters: [], relations:['images','userWishlist','variants.attributeOptions.attribute'], limit: 4)),
                'top_collections' => CollectionResource::collection(app(CollectionService::class)->getAll(filters: [
                    new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc')
                ],limit: 3)),
                'bottom_collections' => CollectionResource::collection(app(CollectionService::class)->getAll(filters: [
                    new SortFilterPipeline(sortByColumn: 'id', sortType: 'desc')
                ],limit: 9)),
            ]
        );
    }
}
