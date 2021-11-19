<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ($request->user()) {
            return $next($request);
        }

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'token_expired'], Response::HTTP_UNAUTHORIZED);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'token_invalid'], Response::HTTP_UNAUTHORIZED);
        } catch (JWTException $e) {
            return response()->json(['error' => 'token_absent'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
