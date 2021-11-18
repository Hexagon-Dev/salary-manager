<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyRecordServiceInterface;
use App\Models\CurrencyRecord;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyRecordController extends Controller
{
    protected CurrencyRecordServiceInterface $service;

    /**
     * @param CurrencyRecordServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(CurrencyRecordServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'currency_record'])) {
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
        if (!$this->user->can(['create', 'currency_record'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

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
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'currency_record'])) {
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
        if (!$this->user->can(['read', 'currency_record'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

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

        if (! $currency_record = $this->service->readOne($id)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var CurrencyRecord $currency_record */
        $currency_record = $this->service->update($currency_record, $request->toArray());

        return response()->json($currency_record, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $currency_record = $this->service->readOne($id);

        /** @var CurrencyRecord $currency_record */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($currency_record));
    }
}
