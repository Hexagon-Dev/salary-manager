<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    protected UserServiceInterface $service;

    /**
     * @param UserServiceInterface $service
     */
    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        return response()->json($this->service->readAll());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'login' => 'required|max:32|min: 6',
            'password' => 'required|max:32|min: 8',
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ]);

        return response()->json($this->service->create($request->all()));
    }

    /**
     * @param string $login
     * @return JsonResponse
     */
    public function readOne(string $login): JsonResponse
    {
        return response()->json($this->service->readOne($login));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, string $login): JsonResponse
    {
        $request->validate([
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ]);

        return response()->json($this->service->update($request->toArray(), $login));
    }

    /**
     * @param string $login
     * @return JsonResponse
     */
    public function delete(string $login): JsonResponse
    {
        return response()->json($this->service->delete($login));
    }
}
