<?php

namespace App\Http\Controllers\Api;

use App\{Http\Controllers\Controller,
    Http\Resources\General\PageResource,
    Services\Settings\PageService,
    Utils\HttpFoundation\Response};

class SettingsController extends Controller
{
    public function terms(): Response
    {
        $page = app(PageService::class)->getBySlug('terms');
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new PageResource(resource: $page)
        );
    }

    public function privacy(): Response
    {
        $page = app(PageService::class)->getBySlug('privacy_policy');
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new PageResource(resource: $page)
        );
    }
}
