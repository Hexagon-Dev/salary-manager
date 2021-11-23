<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SkillServiceInterface;
use App\Http\Requests\Create\CreateSkillRequest;
use App\Http\Requests\Update\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SkillController extends Controller
{
    protected string $serviceInterface = SkillServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/skill",
     *      operationId="getSkillList",
     *      tags={"Skills"},
     *      summary="Get list of skills.",
     *      description="Returns list of skills.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of skills.",
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
     *      path="/api/skill",
     *      operationId="createSkill",
     *      tags={"Skills"},
     *      summary="Creates skill.",
     *      description="Creates skill.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="strinng"
     *                  ),
     *                  example={"name": "swimming"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns skill.",
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
     * @param CreateSkillRequest $request
     * @return JsonResponse
     */
    public function create(CreateSkillRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/skill/{id}",
     *      operationId="getSkill",
     *      tags={"Skills"},
     *      summary="Get one skill.",
     *      description="Returns one skill.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Skill id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns skill.",
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
     *      path="/api/skill/{id}",
     *      operationId="updateSkill",
     *      tags={"Skills"},
     *      summary="Updates skill.",
     *      description="Updates skill parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Skill id",
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
     *                      type="strinng"
     *                  ),
     *                  example={"name": "swimming"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns skill.",
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
     * @param UpdateSkillRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSkillRequest $request, int $id): JsonResponse
    {
        $skill = $this->service->readOne($id);

        /** @var Skill $skill */
        $skill = $this->service->update($skill, $request->validated());

        return response()->json($skill, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/skill/{id}",
     *      operationId="deleteSkill",
     *      tags={"Skills"},
     *      summary="Deletes skill.",
     *      description="Deletes skill.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Skill id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Skill deleted.",
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
