<?php

namespace App\Http\Middleware;

use Closure;

class Authenticate
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()) {
            return response()->json([
                'error' => 'token_absent',
            ], 401);
        }

        return $next($request);
    }
}
