<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected string $serviceInterface = UserServiceInterface::class;

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
     * @param string $login
     * @return int
     */
    public function delete(string $login): int
    {
        return $this->service->delete($login);
    }
}
