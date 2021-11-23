<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CompanyServiceInterface;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    protected string $serviceInterface = CompanyServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/company",
     *      operationId="getCompanyList",
     *      tags={"Companies"},
     *      summary="Get list of companies.",
     *      description="Returns list of companies.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of companies.",
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
     *      path="/api/company",
     *      operationId="createCompany",
     *      tags={"Companies"},
     *      summary="Creates company.",
     *      description="Creates company.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="contacts",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="create_time",
     *                      type="string"
     *                  ),
     *                  example={"type": "Heroku", "contacts": "admin@heroku.com", "create_time": "2006-11-22 12:00:00"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns company.",
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
            'contacts' => 'required|max:255',
            'create_time' => 'required',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/company/{id}",
     *      operationId="getCompany",
     *      tags={"Companies"},
     *      summary="Get one company.",
     *      description="Returns one company.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Company id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns company.",
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
     *      path="/api/company/{id}",
     *      operationId="updateCompany",
     *      tags={"Companies"},
     *      summary="Updates company.",
     *      description="Updates company parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Company id",
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
        $this->checkPermission('update');

        $request->validate([
            'name' => 'required|max:255',
            'contacts' => 'required|max:255',
            'create_time' => 'required',
        ]);

        $company = $this->service->readOne($id);

        /** @var Company $company */
        $company = $this->service->update($company, $request->toArray());

        return response()->json($company, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/company/{id}",
     *      operationId="deleteCompany",
     *      tags={"Companies"},
     *      summary="Deletes company.",
     *      description="Deletes company.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Company id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Company deleted.",
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
