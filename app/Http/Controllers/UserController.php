<?php

namespace App\Http\Controllers;

use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $collection = $this->service->readAll();

        return response()->json($collection->get('message'), $collection->get('status'));
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

        $collection = $this->service->create($request->toArray());

        return response()->json($collection->get('message'), $collection->get('status'));
    }

    /**
     * @param string $login
     * @return JsonResponse
     */
    public function readOne(string $login): JsonResponse
    {
        $collection = $this->service->readOne($login);

        return response()->json($collection->get('message'), $collection->get('status'));
    }

    /**
     * @param Request $request
     * @param string $login
     * @return JsonResponse
     */
    public function update(Request $request, string $login): JsonResponse
    {
        $request->validate([
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ]);

        $collection = $this->service->update($request->toArray(), $login);

        return response()->json($collection->get('message'), $collection->get('status'));
    }

    /**
     * @param string $login
     * @return JsonResponse
     */
    public function delete(string $login): JsonResponse
    {
        $collection = $this->service->delete($login);

        return response()->json($collection->get('message'), $collection->get('status'));
    }
}
