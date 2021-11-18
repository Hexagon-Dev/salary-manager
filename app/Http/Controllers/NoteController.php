<?php

namespace App\Http\Controllers;

use App\Contracts\Services\NoteServiceInterface;
use App\Models\Note;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    protected NoteServiceInterface $service;

    /**
     * @param NoteServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(NoteServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'note'])) {
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
        if (!$this->user->can(['create', 'note'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required',
            'manager_id' => 'required|numeric',
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
        if (!$this->user->can(['read', 'note'])) {
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
        if (!$this->user->can(['read', 'note'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required',
            'manager_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        if (! $note = $this->service->readOne($id)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var Note $note */
        $note = $this->service->update($note, $request->toArray());

        return response()->json($note, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $note = $this->service->readOne($id);

        /** @var Note $note */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($note));
    }
}
