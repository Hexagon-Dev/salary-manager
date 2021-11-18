<?php

namespace App\Contracts\Services;

use App\Models\Salary;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SalaryServiceInterface
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
     * @param Salary $salary
     * @param array $attributes
     * @return Salary
     */
    public function update(Salary $salary, array $attributes): Salary;

    /**
     * @param Salary $salary
     * @return int
     */
    public function delete(Salary $salary): int;
}
