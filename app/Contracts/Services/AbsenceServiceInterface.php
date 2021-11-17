<?php

namespace App\Contracts\Services;

use Illuminate\Database\Eloquent\Collection;

interface AbsenceServiceInterface
{
    /**
     * @return Collection
     */
    public function readAll(): Collection;

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function readOne(int $id): Collection;

    /**
     * @param array $attributes
     * @param int $id
     * @return Collection
     */
    public function update(array $attributes, int $id): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function delete(int $id): Collection;
}
