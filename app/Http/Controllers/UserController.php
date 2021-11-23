<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        $this->checkPermission('read');

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
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function create(CreateUserRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), Response::HTTP_CREATED);
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
        $this->checkPermission('read');

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
     * @param UpdateUserRequest $request
     * @param string $login
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, string $login): JsonResponse
    {
        $this->checkPermission('update');

        $request->validated();

        $user = $this->service->readOne($login);

        /** @var User $user */
        $user = $this->service->update($user, $request->safe()->toArray());

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
        $this->checkPermission('delete');

        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($login));
    }
}
