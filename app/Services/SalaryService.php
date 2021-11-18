<?php

namespace App\Services;

use App\Contracts\Services\SalaryServiceInterface;
use App\Models\Salary;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class SalaryService implements SalaryServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return Salary::all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model
    {
        return Salary::query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Salary::query()->create($attributes);
    }

    /**
     * @param Salary $salary
     * @param array $attributes
     * @return Salary
     */
    public function update(Salary $salary, array $attributes): Salary
    {
        $salary->update($attributes);

        return $salary;
    }

    /**
     * @param Salary $salary
     * @return int
     */
    public function delete(Salary $salary): int
    {
        $salary->delete();

        return Response::HTTP_OK;
    }
}
