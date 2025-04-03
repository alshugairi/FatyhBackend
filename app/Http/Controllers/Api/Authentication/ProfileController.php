<?php

namespace App\Http\Controllers\Api\Authentication;

use App\{Http\Controllers\Controller,
    Http\Requests\Api\Account\UpdateNotificationRequest,
    Http\Requests\Api\Authentication\UpdateProfileRequest,
    Http\Resources\ProfileResource,
    Http\Resources\UserResource,
    Services\UserService,
    Utils\HttpFoundation\HttpStatus,
    Utils\HttpFoundation\Response};
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public function index(): Response
    {
        return Response::response(
            message: __(key:'share.request_successfully'),
            data: new ProfileResource(resource: auth()->user())
        );
    }

    public function update(UpdateProfileRequest $request): Response
    {
        try {
            $user = auth()->user();
            $data = $request->validated();
            $data = upload_file($data, 'avatar', 'users', $user->avatar);

            $user = $this->userService->update(data: $data, id: $user->id);
            $user = $user->load('categories');
            return Response::response(
                message: __(key:'share.request_successfully'),
                data: new ProfileResource(resource: $user)
            );
        } catch (\Exception $e) {
            Log::error('Update profile error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return Response::error(
                message: __('share.error'),
                status: HttpStatus::HTTP_BAD_REQUEST
            );
        }
    }
}
