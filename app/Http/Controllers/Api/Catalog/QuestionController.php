<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Http\Controllers\Controller,
    Http\Resources\Catalog\QuestionResource,
    Http\Resources\Catalog\ReviewResource,
    Pipelines\QuestionFilterPipeline,
    Pipelines\ReviewFilterPipeline,
    Services\Catalog\ProductService,
    Services\QuestionService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};

class QuestionController extends Controller
{
    public function __construct(private readonly QuestionService $questionService,
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
            data: QuestionResource::collection(
                $this->questionService->index(filters: [
                    new QuestionFilterPipeline(request: request()->merge(['product_id' => $product->id])),
                ], paginate: 24)
            )
        );
    }
}
