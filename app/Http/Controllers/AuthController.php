<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
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
     * @param LoginUserRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = User::query()->where(['login' => $request->validated()['login']])->first();

        if (!$user) {
            return response()->json(['error' => 'login or password is incorrect'], Response::HTTP_UNAUTHORIZED);
        }

        if (Hash::check($request->validated()['password'], $user->password)) {
            return response()->json(['token' => $this->getJWTToken($user)]);
        }

        return response()->json(['error' => 'login or password is incorrect'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param RegisterUserRequest $request
     * @return User
     */
    public function register(RegisterUserRequest $request): User
    {
        /** @var User $user */
        $user = User::query()->create($request->validated());
        $user->assignRole(Role::findByName('user'));

        return $user;
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
            'exp' => $time + 7200,
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
