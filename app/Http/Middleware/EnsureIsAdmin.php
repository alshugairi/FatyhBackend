<?php

namespace App\Http\Middleware;

use App\Enums\UserType;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (
            Auth::check() &&
            (in_array(Auth::user()->type, [UserType::ADMIN->value, UserType::BUSINESS_OWNER->value]))
        ) {
            return $next($request);
        }
        Auth::logout();
        return redirect(to: '/admin/login')
                ->with('error', __('share.you_dont_have_permission'))
                ->withInput();
    }
}
