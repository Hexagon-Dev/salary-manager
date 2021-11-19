<?php

namespace App\Contracts\Services;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CompanyServiceInterface
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
     * @param Company $company
     * @param array $attributes
     * @return Company
     */
    public function update(Company $company, array $attributes): Company;

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}
