<?php

namespace App\Http\Controllers\Api\Account;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\UserResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Services\Catalog\BrandService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class AccountController extends Controller
{
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
