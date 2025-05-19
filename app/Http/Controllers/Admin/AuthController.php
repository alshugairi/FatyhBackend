<?php

namespace App\Http\Controllers\Admin;

use App\{Http\Controllers\Controller,
    Http\Requests\Admin\Auth\LoginRequest,
    Http\Requests\Admin\Auth\RegisterCompanyRequest,
    Http\Requests\Admin\Auth\RegisterIndividualRequest};
use Illuminate\{Contracts\View\View, Http\JsonResponse, Http\RedirectResponse, Http\Request, Support\Facades\Auth};

class AuthController extends Controller
{
    /**
     * @return View
     */
    public function login(): View
    {
        return view('admin.modules.auth.login', get_defined_vars());
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function authenticate(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => __('auth.failed')])->withInput();
    }

    /**
     * @return RedirectResponse
     */
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

    }

    public function storeCompany(RegisterCompanyRequest $request): RedirectResponse
    {

    }
}
