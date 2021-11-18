<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected UserServiceInterface $service;
    protected Authenticatable|User|null $user;

    /**
     * @param UserServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(UserServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
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
            'name' => 'max:32',
            'age' => 'max:32',
            'role' => 'max:32',
        ]);

        if (! $user = $this->service->readOne($login)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var User $user */
        $user = $this->service->update($user, $request->toArray());

        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * @param string $login
     * @return JsonResponse
     */
    public function delete(string $login): JsonResponse
    {
        $user = $this->service->readOne($login);

        /** @var User $user */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($user));
    }
}
