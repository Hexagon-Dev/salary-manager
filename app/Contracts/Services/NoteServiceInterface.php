<?php

namespace App\Contracts\Services;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface NoteServiceInterface
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
     * @param Note $note
     * @param array $attributes
     * @return Note
     */
    public function update(Note $note, array $attributes): Note;

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int;
}
