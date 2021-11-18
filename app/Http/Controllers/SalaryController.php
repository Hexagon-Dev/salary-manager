<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SalaryServiceInterface;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalaryController extends Controller
{
    protected SalaryServiceInterface $service;

    /**
     * @param SalaryServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(SalaryServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'salary'])) {
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
        if (!$this->user->can(['create', 'salary'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'amount' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'salary'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        return response()->json($this->service->readOne($id), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'salary'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'amount' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        if (! $salary = $this->service->readOne($id)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var Salary $salary */
        $salary = $this->service->update($salary, $request->toArray());

        return response()->json($salary, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $salary = $this->service->readOne($id);

        /** @var Salary $salary */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($salary));
    }
}
