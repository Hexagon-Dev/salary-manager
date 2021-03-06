<?php

namespace App\Http\Controllers;

use App\Contracts\Services\SalaryServiceInterface;
use App\Http\Requests\Create\CreateSalaryRequest;
use App\Http\Requests\Update\UpdateSalaryRequest;
use App\Models\Salary;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SalaryController extends Controller
{
    protected string $serviceInterface = SalaryServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/salary",
     *      operationId="getSalaryList",
     *      tags={"Salaries"},
     *      summary="Get list of salaries.",
     *      description="Returns list of salaries.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of salaries.",
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
     *      path="/api/salary",
     *      operationId="createSalary",
     *      tags={"Salaries"},
     *      summary="Creates salary.",
     *      description="Creates salary.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="amount",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="currency_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer"
     *                  ),
     *                  example={"amount": "2000", "currency_id": "2", "user_id": "6"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns salary.",
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
     * @param CreateSalaryRequest $request
     * @return JsonResponse
     */
    public function create(CreateSalaryRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/salary/{id}",
     *      operationId="getSalary",
     *      tags={"Salaries"},
     *      summary="Get one salary.",
     *      description="Returns one salary.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Salary id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns salary.",
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
     *      path="/api/salary/{id}",
     *      operationId="updateSalary",
     *      tags={"Salaries"},
     *      summary="Updates salary.",
     *      description="Updates salary parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Salary id",
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
     *                      property="amount",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="currency_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="user_id",
     *                      type="integer"
     *                  ),
     *                  example={"amount": "2000", "currency_id": "2", "user_id": "6"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns salary.",
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
     * @param UpdateSalaryRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateSalaryRequest $request, int $id): JsonResponse
    {
        $salary = $this->service->readOne($id);

        /** @var Salary $salary */
        $salary = $this->service->update($salary, $request->validated());

        return response()->json($salary, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/salary/{id}",
     *      operationId="deleteSalary",
     *      tags={"Salaries"},
     *      summary="Deletes salary.",
     *      description="Deletes salary.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Salary id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Salary deleted.",
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
