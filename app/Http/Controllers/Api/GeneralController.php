<?php

namespace App\Http\Controllers\Api;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Resources\General\CityResource,
    Http\Resources\General\CountryResource,
    Pipelines\Settings\CityFilterPipeline,
    Services\Settings\CityService,
    Services\Settings\CountryService,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function countries(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: CountryResource::collection(app(CountryService::class)->getAll())
        );
    }

    public function cities(Request $request): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: CityResource::collection(app(CityService::class)->getAll(filters: [
                new CityFilterPipeline(request: $request),
            ]))
        );
    }
}
