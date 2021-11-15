<?php

namespace App\Contracts\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface AbsenceServiceInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection;

    /**
     * @param Request $request
     * @return Collection
     */
    public function create(Request $request): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function show(int $id): Collection;

    /**
     * @param Request $request
     * @param int $id
     * @return Collection
     */
    public function update(Request $request, int $id): Collection;

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}
