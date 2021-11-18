<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            try {
                JWTAuth::parseToken()->authenticate();
            } catch (TokenExpiredException $e) {
                return response()->json(Collection::make(['error' => 'token_expired']));
            } catch (TokenInvalidException $e) {
                return response()->json(Collection::make(['error' => 'token_invalid']));
            } catch (JWTException $e) {
                return response()->json(Collection::make(['error' => 'token_absent']));
            }
            return $this->redirectTo($request);
        }
    }
}
