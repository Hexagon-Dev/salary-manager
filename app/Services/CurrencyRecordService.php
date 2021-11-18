<?php

namespace App\Services;

use App\Contracts\Services\CurrencyRecordServiceInterface;
use App\Models\CurrencyRecord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class CurrencyRecordService implements CurrencyRecordServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return CurrencyRecord::all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model
    {
        return CurrencyRecord::query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return CurrencyRecord::query()->create($attributes);
    }

    /**
     * @param CurrencyRecord $currency_record
     * @param array $attributes
     * @return CurrencyRecord
     */
    public function update(CurrencyRecord $currency_record, array $attributes): CurrencyRecord
    {
        $currency_record->update($attributes);

        return $currency_record;
    }

    /**
     * @param CurrencyRecord $currency_record
     * @return int
     */
    public function delete(CurrencyRecord $currency_record): int
    {
        $currency_record->delete();

        return Response::HTTP_OK;
    }
}
