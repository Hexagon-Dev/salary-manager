<?php

namespace App\Services;

use App\Contracts\Services\CurrencyServiceInterface;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class CurrencyService extends AbstractService implements CurrencyServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return Currency::all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model
    {
        return Currency::query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Currency::query()->create($attributes);
    }

    /**
     * @param Currency $currency
     * @param array $attributes
     * @return Currency
     */
    public function update(Currency $currency, array $attributes): Currency
    {
        $currency->update($attributes);

        return $currency;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        Currency::query()->where('id', $id)->delete();

        return Response::HTTP_OK;
    }
}
