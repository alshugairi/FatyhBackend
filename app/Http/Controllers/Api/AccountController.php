<?php

namespace App\Http\Controllers\Api;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Account\Api\UpdateInfoRequest,
    Http\Requests\Account\UpdatePasswordRequest,
    Services\UserService,
    Utils\HttpFoundation\Response};
use Illuminate\{Contracts\View\View, Http\RedirectResponse, Support\Facades\DB};

class AccountController extends Controller
{
    public function __construct(private readonly UserService $service)
    {
    }

    public function info(): View
    {
        return view('account.modules.account_info', get_defined_vars());
    }

    public function updateInfo(UpdateInfoRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $this->service->update($request->validated(), $user->id);
        flash(__('frontend.info_updated_successfully'))->success();
        return back();
    }

    public function changePassword(): View
    {
        return view('account.modules.change_password', get_defined_vars());
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $user = auth()->user();
        $this->service->update($request->validated(), $user->id);
        flash(__('frontend.password_updated_successfully'))->success();
        return back();
    }
}
