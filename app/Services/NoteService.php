<?php

namespace App\Services;

use App\Contracts\Services\NoteServiceInterface;
use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Response;

class NoteService extends AbstractService implements NoteServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return Note::all();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function readOne(int $id): Model
    {
        return Note::query()->where('id', $id)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function create(array $attributes): Model
    {
        return Note::query()->create($attributes);
    }

    /**
     * @param Note $note
     * @param array $attributes
     * @return Note
     */
    public function update(Note $note, array $attributes): Note
    {
        $note->update($attributes);

        return $note;
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        Note::query()->where('id', $id)->delete();

        return Response::HTTP_OK;
    }
}
