<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="login",
     *      tags={"Auth"},
     *      summary="Logs in user.",
     *      description="Returns token in responce.",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="login",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  example={"login": "admin", "password": "admin"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns token.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     *     )
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $login = $request->get('login','');
        $password = $request->get('password','');
        $user = User::query()->where(['login' => $login])->first();
        if (!$user) {
            return response()->json(['error' => 'login or password is incorrect'], Response::HTTP_UNAUTHORIZED);
        }
        if (Hash::check($password, $user->password)) {
            unset($user['password']);
            cache('user-' . $user['id'], $user);
            return response()->json(['token' => $this->getJWTToken($user)]);
        }
        return response()->json(['error' => 'login or password is incorrect'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @OA\Post(
     *      path="/api/logout",
     *      operationId="logout",
     *      tags={"Auth"},
     *      summary="Logs user out.",
     *      description="Invalidates the token.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Logs user out.",
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
        return response()->json(['message' => 'successfully logged out']);
    }

    /**
     * @param $value
     * @return string
     */
    public function getJWTToken($value): string
    {
        $time = time();
        $payload = [
            'iat' => $time,
            'nbf' => $time,
            'exp' => $time+7200,
            'data' => [
                'id' => $value['id'],
                'username' => $value['user_name']
            ]
        ];
        $key =  env('JWT_SECRET');
        $alg = 'HS256';
        return JWT::encode($payload,$key,$alg);
    }
}
