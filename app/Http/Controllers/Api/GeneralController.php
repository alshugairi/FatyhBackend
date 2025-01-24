<?php

namespace App\Http\Controllers\Api;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\ContactRequest,
    Http\Resources\General\CityResource,
    Http\Resources\General\CountryResource,
    Http\Resources\General\FaqCategoryResource,
    Http\Resources\General\FaqResource,
    Http\Resources\General\PageResource,
    Pipelines\Settings\CityFilterPipeline,
    Pipelines\Settings\FaqCategoryFilterPipeline,
    Pipelines\Settings\PostFilterPipeline,
    Services\ContactService,
    Services\Settings\CityService,
    Services\Settings\CountryService,
    Services\Settings\FaqCategoryService,
    Services\Settings\PostService,
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

    public function page(string $slug): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new PageResource(app(PostService::class)->getBySlug($slug))
        );
    }

    public function faqCategories(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: FaqCategoryResource::collection(app(FaqCategoryService::class)->getAll(filters: [
                new FaqCategoryFilterPipeline(request: request()->merge(['is_active' => 1])),
            ], relations: ['faqs']))
        );
    }

    public function contact(ContactRequest $request): Response
    {
        app(ContactService::class)->create(data: $request->validated());
        return Response::response(
            message: __(key:'share.msg_sent_successfully'),
        );
    }
}
