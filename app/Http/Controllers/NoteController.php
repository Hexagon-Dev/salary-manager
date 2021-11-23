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
    protected string $serviceInterface = NoteServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/note",
     *      operationId="getNoteList",
     *      tags={"Notes"},
     *      summary="Get list of notes.",
     *      description="Returns list of notes.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of notes.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        $this->checkPermission('read');

        return response()->json($this->service->readAll(), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/note",
     *      operationId="createNote",
     *      tags={"Notes"},
     *      summary="Creates note.",
     *      description="Creates note.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="date",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="manager_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer"
     *                  ),
     *                  example={"name": "Test", "date": "2021-11-16 12:00:40", "manager_id": "6", "user_id": "8"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns note.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $this->checkPermission('create');

        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required',
            'manager_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/note/{id}",
     *      operationId="getNote",
     *      tags={"Notes"},
     *      summary="Get one note.",
     *      description="Returns one note.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Note id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns note.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        $this->checkPermission('read');

        return response()->json($this->service->readOne($id), Response::HTTP_OK);
    }

    /**
     * @OA\Patch (
     *      path="/api/note/{id}",
     *      operationId="updateNote",
     *      tags={"Notes"},
     *      summary="Updates note.",
     *      description="Updates note parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Note id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="date",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="manager_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer"
     *                  ),
     *                  example={"name": "Test", "date": "2021-11-16 12:00:40", "manager_id": "6", "user_id": "8"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns absence.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $this->checkPermission('update');

        $request->validate([
            'name' => 'required|max:255',
            'date' => 'required',
            'manager_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        $note = $this->service->readOne($id);

        /** @var Note $note */
        $note = $this->service->update($note, $request->toArray());

        return response()->json($note, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/note/{id}",
     *      operationId="deleteNote",
     *      tags={"Notes"},
     *      summary="Deletes note.",
     *      description="Deletes note.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Note id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Note deleted.",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     *
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $this->checkPermission('delete');

        return $this->service->delete($id);
    }
}
