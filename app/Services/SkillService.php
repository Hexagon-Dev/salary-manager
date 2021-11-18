<?php

namespace App\Services;

use App\Contracts\Services\SkillServiceInterface;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class SkillService implements SkillServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return Skill::all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model
    {
        return Skill::query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Skill::query()->create($attributes);
    }

    /**
     * @param Skill $skill
     * @param array $attributes
     * @return Skill
     */
    public function update(Skill $skill, array $attributes): Skill
    {
        $skill->update($attributes);

        return $skill;
    }

    /**
     * @param Skill $skill
     * @return int
     */
    public function delete(Skill $skill): int
    {
        $skill->delete();

        return Response::HTTP_OK;
    }
}
