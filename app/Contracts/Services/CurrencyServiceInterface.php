<?php

namespace App\Contracts\Services;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CurrencyServiceInterface
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
     * @param Currency $currency
     * @param array $attributes
     * @return Currency
     */
    public function update(Currency $currency, array $attributes): Currency;

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}
