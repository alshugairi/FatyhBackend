<?php

namespace App\Http\Controllers\Api\Catalog;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\BrandResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Services\Catalog\BrandService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: BrandResource::collection(app(BrandService::class)->index(filters: [
                new BrandFilterPipeline(request: request()->merge(['status' => StatusEnum::ACTIVE->value])),
            ], paginate: 24))
        );
    }
}
