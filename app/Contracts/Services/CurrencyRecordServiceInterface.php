<?php

namespace App\Contracts\Services;

use App\Models\CurrencyRecord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CurrencyRecordServiceInterface
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
     * @param CurrencyRecord $currency_record
     * @param array $attributes
     * @return CurrencyRecord
     */
    public function update(CurrencyRecord $currency_record, array $attributes): CurrencyRecord;

    /**
     * @param CurrencyRecord $currency_record
     * @return int
     */
    public function delete(CurrencyRecord $currency_record): int;
}
