<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateToken
{
    /**
     * Authenticate the request using the Bearer token issued at login/signup.
     * Responds with the spec-defined 403 "Login failed" body when missing/invalid.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $user = $token ? User::where('api_token', $token)->first() : null;

        if (! $user) {
            return response()->json(['message' => 'Login failed'], 403);
        }

        auth()->setUser($user);

        return $next($request);
    }
}
