<?php

namespace App\Http\Controllers\Api;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\CategoryResource,
    Models\Category,
    Pipelines\CategoryFilterPipeline,
    Services\CategoryService,
    Utils\HttpFoundation\Response};

class GeneralController extends Controller
{
    public function categories(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: CategoryResource::collection(app(CategoryService::class)->getAll(filters: [
                new CategoryFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value])),
            ]))
        );
    }
}
