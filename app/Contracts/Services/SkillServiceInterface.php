<?php

namespace App\Contracts\Services;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SkillServiceInterface
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
     * @param Skill $skill
     * @param array $attributes
     * @return Skill
     */
    public function update(Skill $skill, array $attributes): Skill;

    /**
     * @param Skill $skill
     * @return int
     */
    public function delete(Skill $skill): int;
}
