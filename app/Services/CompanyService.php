<?php

namespace App\Services;

use App\Contracts\Services\CompanyServiceInterface;
use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class CompanyService extends AbstractService implements CompanyServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return Company::all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model
    {
        return Company::query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Company::query()->create($attributes);
    }

    /**
     * @param Company $company
     * @param array $attributes
     * @return Company
     */
    public function update(Company $company, array $attributes): Company
    {
        $company->update($attributes);

        return $company;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        Company::query()->where('id', $id)->delete();

        return Response::HTTP_OK;
    }
}
