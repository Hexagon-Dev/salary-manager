<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

class AbsenceController extends Controller
{
    protected ?Authenticatable $user;

    public function __construct(/*Authenticatable $user*/)
    {
        //$this->user = $user;
        $this->user = auth()->user();
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'absence'])) {
            return response()->json(['error' => 'access_denied']);
        }

        return response()->json(Absence::query()->get()->toArray());
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'absence'])) {
            return response()->json(['error' => 'access_denied']);
        }

        return response()->json(Absence::query()->get()->where($id)->first()->toArray());
    }

    /**
     * @param array $attributes
     * @return JsonResponse
     */
    public function create(array $attributes): JsonResponse
    {
        if (!$this->user->can(['create', 'absence'])) {
            return response()->json(['error' => 'access_denied']);
        }

        $absence = Absence::query()->create($attributes);
        return response()->json($absence);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return JsonResponse
     */
    public function update(array $attributes, int $id): JsonResponse
    {
        if (!$this->user->can(['update', 'absence'])) {
            return response()->json(['error' => 'access_denied']);
        }

        $absence = Absence::query()->findOrFail($id);
        $absence->update($attributes);
        dd($absence);
        return response()->json($absence);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        if (!$this->user->can(['delete', 'absence'])) {
            return response()->json(['error' => 'access_denied']);
        }

        $absence = Absence::query()->findOrFail($id);
        $absence->delete();

        return response()->json(['message' => 'deleted']);
    }
}
