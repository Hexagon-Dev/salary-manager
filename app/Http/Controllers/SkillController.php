<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SkillServiceInterface;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends Controller
{
    protected SkillServiceInterface $service;

    /**
     * @param SkillServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(SkillServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'skill'])) {
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
        if (!$this->user->can(['create', 'skill'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'skill'])) {
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
        if (!$this->user->can(['read', 'skill'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'required|max:255',
        ]);

        if (! $skill = $this->service->readOne($id)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var Skill $skill */
        $skill = $this->service->update($skill, $request->toArray());

        return response()->json($skill, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $skill = $this->service->readOne($id);

        /** @var Skill $skill */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($skill));
    }
}
