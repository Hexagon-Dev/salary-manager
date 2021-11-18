<?php

namespace App\Services;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Models\Absence;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class AbsenceService extends AbstractService implements AbsenceServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return Absence::all();
    }

    /**
     * @param int $id
     * @return ?Model
     */
    public function readOne(int $id): ?Model
    {
        return Absence::query()->where('id', $id)->first();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Absence::query()->create($attributes);
    }

    /**
     * @param Absence $absence
     * @param array $attributes
     * @return Absence
     */
    public function update(Absence $absence, array $attributes): Absence
    {
        $absence->update($attributes);

        return $absence;
    }

    /**
     * @param Absence $absence
     * @return int
     */
    public function delete(Absence $absence): int
    {
        $absence->delete();

        return Response::HTTP_OK;
    }
}
