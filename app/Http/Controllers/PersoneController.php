<?php

namespace App\Http\Controllers;

use App\Contracts\Services\PersoneServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PersoneController extends Controller
{
    protected PersoneServiceInterface $service;

    /**
     * @param PersoneServiceInterface $personeService
     */
    public function __construct(PersoneServiceInterface $personeService)
    {
        $this->service = $personeService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->index());
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ]);

        return response()->json($this->service->create($request));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->show($id));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ]);

        return response()->json($this->service->update($request, $id));
    }

    /**
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        return Response('', $this->service->delete($id));
    }
}
