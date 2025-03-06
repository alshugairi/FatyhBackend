<?php

namespace App\Http\Controllers\Api;

use App\{Http\Controllers\Controller,
    Http\Resources\BusinessResource,
    Http\Resources\Catalog\ProductResource,
    Http\Resources\Catalog\ReviewResource,
    Pipelines\ReviewFilterPipeline,
    Services\WishlistService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};

class WishlistController extends Controller
{
    public function __construct(private readonly WishlistService $wishlistService)
    {
    }

    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ProductResource::collection($this->wishlistService->getWishlist())
        );
    }
}
