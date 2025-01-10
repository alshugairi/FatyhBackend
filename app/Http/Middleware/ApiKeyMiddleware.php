<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('x-api-key');

        $validApiKey = 'cb816998-c908-4282-a61c-522423cacaad';

        if ($apiKey !== $validApiKey) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
