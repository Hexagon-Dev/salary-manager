<?php

namespace App\Services;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Models\Absence;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AbsenceService implements AbsenceServiceInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return Absence::all();
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function create(Request $request): Collection
    {
        return Collection::make(Absence::query()->create($request->all())->toArray());
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function show(int $id): Collection
    {
        return Collection::make(Absence::query()->find($id));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Collection
     */
    public function update(Request $request, int $id): Collection
    {
        $article = Absence::query()->findOrFail($id);
        $article->update($request->all());

        return Collection::make($article);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $article = Absence::query()->findOrFail($id);
        $article->delete();

        return 200;
    }
}
