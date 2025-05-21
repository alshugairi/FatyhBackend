<?php

namespace App\Http\Controllers\Admin;

use App\{Enums\UserType,
    Http\Controllers\Controller,
    Http\Requests\Admin\Auth\LoginRequest,
    Http\Requests\Admin\Auth\RegisterCompanyRequest,
    Http\Requests\Admin\Auth\RegisterIndividualRequest,
    Services\BusinessService,
    Services\UserService};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Http\Request, Support\Facades\Auth};

class AuthController extends Controller
{
    public function __construct(private readonly UserService $userService,
                                private readonly BusinessService $businessService)
    {
    }

    public function login(): View
    {
        return view('admin.modules.auth.login', get_defined_vars());
    }

    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => __('auth.failed')])->withInput();
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    public function register(): View
    {
        return view('admin.modules.auth.register', get_defined_vars());
    }

    public function storeIndividual(RegisterIndividualRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['name'] = $data['first_name'] . ' ' . $data['middle_name']. ' ' . $data['last_name'];

        $business = $this->businessService->create(data: $data);
        $user = $this->userService->create(data: $data);

        $this->userService->update(data: ['business_id' => $business->id], id: $user->id);
        flash(__('admin.created_successfully', ['module' => __('admin.seller')]))->success();
        auth()->login($user);
        return redirect()->route(route: 'admin.admins.index');
    }

    public function storeCompany(RegisterCompanyRequest $request): RedirectResponse
    {

    }
}
