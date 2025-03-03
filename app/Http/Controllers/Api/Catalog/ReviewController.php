<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\ReviewResource,
    Pipelines\ReviewFilterPipeline,
    Services\Catalog\ProductService,
    Services\ReviewService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private readonly ReviewService $reviewService,
                                private readonly ProductService $productService)
    {
    }

    public function index(int $id): Response
    {
        $product = $this->productService->find(id: $id);

        if (!$product) {
            return Response::error(
                message: __(key:'share.product_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ReviewResource::collection(
                $this->reviewService->index(filters: [
                    new ReviewFilterPipeline(request: request()->merge(['product_id' => $product->id])),
                ], paginate: 24)
            )
        );
    }
}
