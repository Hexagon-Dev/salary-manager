<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected string $serviceInterface = UserServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/user",
     *      operationId="getUserList",
     *      tags={"Users"},
     *      summary="Get list of users.",
     *      description="Returns list of users.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of users.",
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
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'user'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        return response()->json($this->service->readAll(), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/user",
     *      operationId="createUser",
     *      tags={"Users"},
     *      summary="Creates user.",
     *      description="Creates user.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="login",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="email",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="age",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="role",
     *                      type="integer"
     *                  ),
     *                  example={
     *                      "login": "username",
     *                      "email": "username@example.com",
     *                      "password": "password",
     *                      "name": "Ivan",
     *                      "age": "20",
     *                      "role": 5
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns user.",
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
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'login' => 'required|max:32|min:6|unique:users',
            'email' => 'required|max:32|min:6|unique:users',
            'password' => 'required|max:32|min:8',
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/user/{user}",
     *      operationId="getUser",
     *      tags={"Users"},
     *      summary="Get one user.",
     *      description="Returns one user.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="login",
     *          description="User login",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns user.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     *     )
     *
     * @param string $login
     * @return JsonResponse
     */
    public function readOne(string $login): JsonResponse
    {
        if (!$this->user->can(['read', 'user'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        return response()->json($this->service->readOne($login), Response::HTTP_OK);
    }

    /**
     * @OA\Patch (
     *      path="/api/user/{user}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Updates user.",
     *      description="Updates user parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="user",
     *          description="User login",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns absence",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Required field is empty"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     *     )
     *
     * @param Request $request
     * @param string $login
     * @return JsonResponse
     */
    public function update(Request $request, string $login): JsonResponse
    {
        if (!$this->user->can(['update', 'user'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'email' => 'required',
            'name' => 'max:32',
            'age' => 'max:32',
            'role' => 'max:32',
        ]);

        $user = $this->service->readOne($login);

        /** @var User $user */
        $user = $this->service->update($user, $request->toArray());

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/user/{user}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Deletes user.",
     *      description="Deletes user.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="login",
     *          description="User login",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User deleted.",
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
     * @param string $login
     * @return JsonResponse
     */
    public function delete(string $login): JsonResponse
    {
        if (!$this->user->can(['delete', 'user'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($login));
    }
}
