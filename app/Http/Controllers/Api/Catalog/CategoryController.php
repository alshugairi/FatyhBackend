<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\CategoryResource,
    Pipelines\Catalog\CategoryFilterPipeline,
    Services\Catalog\CategoryService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: CategoryResource::collection(app(CategoryService::class)->index(filters: [
                new CategoryFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value])),
            ]))
        );
    }
}
