<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Models\Absence;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbsenceController extends Controller
{
    protected AbsenceServiceInterface $service;
    protected Authenticatable|User|null $user;

    /**
     * @param AbsenceServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(AbsenceServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'absence'])) {
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
        if (!$this->user->can(['create', 'absence'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'type' => 'int',
            'persone_id' => 'int',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'absence'])) {
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
        if (!$this->user->can(['read', 'absence'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'type' => 'required|numeric',
            'persone_id' => 'required|numeric',
        ]);

        if (! $absence = $this->service->readOne($id)) {
            return response()->json(['error' => 'absence_not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var Absence $absence */
        $absence = $this->service->update($absence, $request->toArray());

        return response()->json($absence, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $absence = $this->service->readOne($id);

        /** @var Absence $absence */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($absence));
    }
}
