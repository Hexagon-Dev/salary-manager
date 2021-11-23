<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyRecordServiceInterface;
use App\Models\CurrencyRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyRecordController extends Controller
{
    protected string $serviceInterface = CurrencyRecordServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/currency_record",
     *      operationId="getCurrencyRecordList",
     *      tags={"CurrencyRecords"},
     *      summary="Get list of currency records.",
     *      description="Returns list of currency records.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of currency records.",
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
     *      path="/api/currency_record",
     *      operationId="createCurrencyRecord",
     *      tags={"CurrencyRecords"},
     *      summary="Creates currency list.",
     *      description="Creates currency list.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="company_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="project_salary",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="currency_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="bank_rate",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="tax_rate",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="net",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="month",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="operation_date",
     *                      type="string"
     *                  ),
     *                  example={
     *                      "company_id": "4",
     *                      "project_salary": "50000",
     *                      "currency_id": "1",
     *                      "bank_rate": "5",
     *                      "tax_rate": "8",
     *                      "net": "6",
     *                      "month": "3",
     *                      "operation_date": "2006-11-22 12:00:00",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns currency record.",
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
            'company_id' => 'required|numeric',
            'project_salary' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'bank_rate' => 'required',
            'tax_rate' => 'required',
            'net' => 'required',
            'month' => 'required',
            'operation_date' => 'required',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/currency_record/{id}",
     *      operationId="getCurrencyRecord",
     *      tags={"CurrencyRecords"},
     *      summary="Get one currency record.",
     *      description="Returns one currency record.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Currency record id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns currency record.",
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
     *      path="/api/currency_record/{id}",
     *      operationId="updateCurrencyRecord",
     *      tags={"CurrencyRecords"},
     *      summary="Updates currency record.",
     *      description="Updates currency record parameters that were given in request.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Currency record id",
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
     *                      property="company_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="project_salary",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="currency_id",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="bank_rate",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="tax_rate",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="net",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="month",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="operation_date",
     *                      type="string"
     *                  ),
     *                  example={
     *                      "company_id": "4",
     *                      "project_salary": "50000",
     *                      "currency_id": "1",
     *                      "bank_rate": "5",
     *                      "tax_rate": "8",
     *                      "net": "6",
     *                      "month": "3",
     *                      "operation_date": "2006-11-22 12:00:00",
     *                  }
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns currency record.",
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
            'company_id' => 'required|numeric',
            'project_salary' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'bank_rate' => 'required',
            'tax_rate' => 'required',
            'net' => 'required',
            'month' => 'required',
            'operation_date' => 'required',
        ]);

        $currency_record = $this->service->readOne($id);

        /** @var CurrencyRecord $currency_record */
        $currency_record = $this->service->update($currency_record, $request->toArray());

        return response()->json($currency_record, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/currency_record/{id}",
     *      operationId="deleteCurrencyRecord",
     *      tags={"CurrencyRecords"},
     *      summary="Deletes currency record.",
     *      description="Deletes currency record.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Currency record id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Currency record deleted.",
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
