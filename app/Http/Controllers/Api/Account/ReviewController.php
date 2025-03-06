<?php

namespace App\Http\Controllers\Api\Account;

use App\{Http\Controllers\Controller,
    Http\Resources\Catalog\ReviewResource,
    Pipelines\ReviewFilterPipeline,
    Services\ReviewService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private readonly ReviewService $reviewService)
    {
    }

    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: ReviewResource::collection(
                $this->reviewService->index(filters: [
                    new ReviewFilterPipeline(request: request()->merge(['user_id' => auth()->id()])),
                ], paginate: 24)
            )
        );
    }
}
