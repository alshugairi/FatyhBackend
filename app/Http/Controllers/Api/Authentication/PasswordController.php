<?php

namespace App\Http\Controllers\Api\Authentication;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\Authentication\ChangePasswordRequest,
    Http\Requests\Api\Authentication\ResetPasswordRequest,
    Services\UserService,
    Utils\HttpFoundation\Response};

class PasswordController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function resetPassword(ResetPasswordRequest $request): Response
    {
        $this->userService->update(data: $request->validated(), id: auth()->id());
        return Response::response(
            message: __(key:'share.success_change_password'),
        );
    }

    public function changePassword(ChangePasswordRequest $request): Response
    {
        $this->userService->update(data: $request->validated(), id: auth()->id());
        return Response::response(
            message: __(key:'share.success_change_password'),
        );
    }
}
