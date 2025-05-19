<?php

namespace App\Http\Controllers\Api;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\NewsletterSubscriptionRequest,
    Services\NewsletterSubscriptionService,
    Utils\HttpFoundation\Response};

class NewsletterSubscriptionController extends Controller
{
    public function __construct(private readonly NewsletterSubscriptionService $service)
    {
    }

    public function store(NewsletterSubscriptionRequest $request): Response
    {
        $this->service->create(data: $request->validated());
        return Response::response(
            message: __('share.email_added_successfully'),
        );
    }
}
