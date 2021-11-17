<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Models\Absence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    protected AbsenceServiceInterface $service;

    /**
     * @param AbsenceServiceInterface $service
     */
    public function __construct(AbsenceServiceInterface $service)
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
            'type' => 'int',
            'persone_id' => 'int',
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
            'type' => 'int',
            'persone_id' => 'int',
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
