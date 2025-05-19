<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\QuestionRequest,
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

    public function store(QuestionRequest $request, int $id): Response
    {
        $product = $this->productService->find(id: $id);

        if (!$product) {
            return Response::error(
                message: __(key:'share.product_not_found'),
                status: HttpStatus::HTTP_NOT_FOUND,
            );
        }

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['product_id'] = $product->id;
        $data['business_id'] = $product->business_id;
        $this->questionService->create(data: $data);

        return Response::response(
            message: __(key:'share.question_added_successfully'),
        );
    }
}
