<?php

namespace App\Http\Controllers;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Models\Absence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AbsenceController extends Controller
{
    protected string $serviceInterface = AbsenceServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/absence",
     *      operationId="getAbsenceList",
     *      tags={"Absences"},
     *      summary="Get list of absences.",
     *      description="Returns list of absences.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of absences.",
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
        if (!$this->user->can(['read', 'absence'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        return response()->json($this->service->readAll(), Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/absence",
     *      operationId="createAbsence",
     *      tags={"Absences"},
     *      summary="Creates absence.",
     *      description="Creates absence.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="type",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer"
     *                  ),
     *                  example={"type": "2", "user_id": "4"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
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
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        if (!$this->user->can(['create', 'absence'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'type' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/absence/{absence}",
     *      operationId="getAbsence",
     *      tags={"Absences"},
     *      summary="Get one absence.",
     *      description="Returns one absence.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Absence id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
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
     * @OA\Patch (
     *      path="/api/absence/{absence}",
     *      operationId="updateAbsence",
     *      tags={"Absences"},
     *      summary="Updates absence.",
     *      description="Updates absence parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Absence id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
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
        if (!$this->user->can(['read', 'absence'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'type' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        $absence = $this->service->readOne($id);

        /** @var Absence $absence */
        $absence = $this->service->update($absence, $request->toArray());

        return response()->json($absence, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/absence/{id}",
     *      operationId="deleteAbsence",
     *      tags={"Absences"},
     *      summary="Deletes absence.",
     *      description="Deletes absence.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Absence id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Abstence deleted.",
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
        return $this->service->delete($id);
    }
}
