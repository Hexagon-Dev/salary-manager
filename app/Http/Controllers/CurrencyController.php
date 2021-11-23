<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Http\Requests\Create\CreateCurrencyRequest;
use App\Http\Requests\Update\UpdateCurrencyRequest;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    protected string $serviceInterface = CurrencyServiceInterface::class;

    /**
     * @OA\Get(
     *      path="/api/currency",
     *      operationId="getCurrencyList",
     *      tags={"Currencies"},
     *      summary="Get list of currencies.",
     *      description="Returns list of currencies.",
     *      security={
     *          {"Bearer Token": {}},
     *      },
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of currencies.",
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
     *      path="/api/currency",
     *      operationId="createCurrency",
     *      tags={"Currencies"},
     *      summary="Creates currency.",
     *      description="Creates currency.",
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
     *                      property="rate",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="symbol",
     *                      type="string"
     *                  ),
     *                  example={"name": "dollar", "rate": "5", "symbol": "$"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Returns currency.",
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
     * @param CreateCurrencyRequest $request
     * @return JsonResponse
     */
    public function create(CreateCurrencyRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/currency/{id}",
     *      operationId="getCurrency",
     *      tags={"Currencies"},
     *      summary="Get one currency.",
     *      description="Returns one currency.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *     @OA\Parameter(
     *          name="id",
     *          description="Currency id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns currency.",
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
     *      path="/api/currency/{id}",
     *      operationId="updateCurrency",
     *      tags={"Currencies"},
     *      summary="Updates currency.",
     *      description="Updates currency parameters that were given in request.",
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
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="name",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="rate",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="symbol",
     *                      type="string"
     *                  ),
     *                  example={"name": "dollar", "rate": "5", "symbol": "$"}
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns currency.",
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
     * @param UpdateCurrencyRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateCurrencyRequest $request, int $id): JsonResponse
    {
        if (! $currency = $this->service->readOne($id)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var Currency $currency */
        $currency = $this->service->update($currency, $request->validated());

        return response()->json($currency, Response::HTTP_OK);
    }

    /**
     * @OA\Delete (
     *      path="/api/currency/{id}",
     *      operationId="deleteCurrency",
     *      tags={"Currencies"},
     *      summary="Deletes currency.",
     *      description="Deletes currency.",
     *      security={
     *        {"Bearer Token": {}},
     *      },
     *      @OA\Parameter(
     *          name="id",
     *          description="Currency id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Currency deleted.",
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
