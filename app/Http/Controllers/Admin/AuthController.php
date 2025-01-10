<?php

namespace App\Http\Controllers\Admin;

use App\{Http\Controllers\Controller, Http\Requests\Admin\Auth\LoginRequest};
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
}
