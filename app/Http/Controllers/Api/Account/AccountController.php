<?php

namespace App\Http\Controllers\Api\Account;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\Catalog\QuestionResource,
    Http\Resources\UserResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Pipelines\QuestionFilterPipeline,
    Services\Catalog\BrandService,
    Services\Catalog\ProductService,
    Services\QuestionService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function __construct(private readonly QuestionService $questionService,
                                private readonly ProductService $productService)
    {
    }

    public function questions(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: QuestionResource::collection(
                $this->questionService->index(filters: [
                    new QuestionFilterPipeline(request: request()->merge(['user_id' => auth()->id()])),
                ], paginate: 24)
            )
        );
    }

    public function profile(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new UserResource(auth()->user())
        );
    }

    public function reviews(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: BrandResource::collection(app(BrandService::class)->index(filters: [
                new BrandFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value])),
            ]))
        );
    }
}
