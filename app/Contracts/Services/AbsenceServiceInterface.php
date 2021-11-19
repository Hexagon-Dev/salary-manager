<?php

namespace App\Contracts\Services;

use App\Models\Absence;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface AbsenceServiceInterface
{
    /**
     * @return Collection
     */
    public function readAll(): Collection;

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model;

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model;

    /**
     * @param Absence $absence
     * @param array $attributes
     * @return Absence
     */
    public function update(Absence $absence, array $attributes): Absence;

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}
