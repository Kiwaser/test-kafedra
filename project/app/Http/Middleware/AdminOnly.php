<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Must run after auth.token. Blocks non-admin users per the spec's
     * "Forbidden for you" 403 response.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden for you'], 403);
        }

        return $next($request);
    }
}
