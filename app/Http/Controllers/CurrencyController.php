<?php

namespace App\Http\Controllers;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CurrencyController extends Controller
{
    protected CurrencyServiceInterface $service;

    /**
     * @param CurrencyServiceInterface $service
     * @param Authenticatable|null $user
     */
    public function __construct(CurrencyServiceInterface $service, ?Authenticatable $user = null)
    {
        $this->service = $service;
        $this->user = $user;
    }

    /**
     * @return JsonResponse
     */
    public function readAll(): JsonResponse
    {
        if (!$this->user->can(['read', 'currency'])) {
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
        if (!$this->user->can(['create', 'currency'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'required|max:255',
            'rate' => 'required',
            'symbol' => 'required|max:255',
        ]);

        return response()->json($this->service->create($request->toArray()), Response::HTTP_CREATED);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function readOne(int $id): JsonResponse
    {
        if (!$this->user->can(['read', 'currency'])) {
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
        if (!$this->user->can(['read', 'currency'])) {
            return response()->json(['error' => 'access_denied'], Response::HTTP_FORBIDDEN);
        }

        $request->validate([
            'name' => 'required|max:255',
            'rate' => 'required',
            'symbol' => 'required|max:255',
        ]);

        if (! $currency = $this->service->readOne($id)) {
            return response()->json(['error' => 'not_found'], Response::HTTP_NOT_FOUND);
        }

        /** @var Currency $currency */
        $currency = $this->service->update($currency, $request->toArray());

        return response()->json($currency, Response::HTTP_OK);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $currency = $this->service->readOne($id);

        /** @var Currency $currency */
        return response()->json(['message' => 'successfully_deleted'], $this->service->delete($currency));
    }
}
