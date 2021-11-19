<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      operationId="loginAuth",
     *      tags={"Auth"},
     *      summary="Responces with token.",
     *      description="Responces with token.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  example={"email": "user@example.com", "password": "user"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns JWT token.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     *     )
     *
     * @return JsonResponse
     */
    public function login(): JsonResponse
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/me",
     *      operationId="meAuth",
     *      tags={"Auth"},
     *      summary="Gets the authenticated user.",
     *      description="Gets the authenticated user.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns authenticated user.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @return Collection
     */
    public function me(): Collection
    {
        return collect(auth()->user());
    }

    /**
     * @OA\Post(
     *      path="/api/auth/logout",
     *      operationId="logoutAuth",
     *      tags={"Auth"},
     *      summary="Logs out.",
     *      description="Logs out.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Logs out.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *      path="/api/auth/refresh",
     *      operationId="refreshAuth",
     *      tags={"Auth"},
     *      summary="Refreshes token.",
     *      description="Token expires in 1 hour. You can refresh it here.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns new token.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @return JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
