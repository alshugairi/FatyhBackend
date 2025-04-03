<?php

namespace App\Http\Controllers\Api\Account;

use App\{Enums\StatusEnum,
    Http\Controllers\Controller,
    Http\Requests\Api\Account\ChangePasswordRequest,
    Http\Requests\Api\Account\UpdateNotificationRequest,
    Http\Requests\Api\Account\UpdateProfileRequest,
    Http\Resources\Catalog\BrandResource,
    Http\Resources\Catalog\QuestionResource,
    Http\Resources\ProfileResource,
    Http\Resources\UserResource,
    Pipelines\Catalog\BrandFilterPipeline,
    Pipelines\QuestionFilterPipeline,
    Services\Catalog\BrandService,
    Services\Catalog\ProductService,
    Services\QuestionService,
    Services\UserService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function profile(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new UserResource(auth()->user())
        );
    }

    public function updateProfile(UpdateProfileRequest $request): Response
    {
        $this->userService->update(data: $request->validated(), id: auth()->id());

        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new UserResource(auth()->user())
        );
    }

    public function changePassword(ChangePasswordRequest $request): Response
    {
        $this->userService->update(data: $request->validated(), id: auth()->id());

        return Response::response(
            message: __(key:'share.success_change_password'),
        );
    }

    public function updateNotificationSettings(UpdateNotificationRequest $request): Response
    {
        try {
            $user = auth()->user();

            $user = $this->userService->update(data: $request->validated(), id: $user->id);
            return Response::response(
                message: __(key:'share.request_successfully'),
                data: new ProfileResource(resource: $user)
            );
        } catch (\Exception $e) {
            return Response::error(
                message: __('share.error'),
                status: HttpStatus::HTTP_BAD_REQUEST
            );
        }
    }
}
