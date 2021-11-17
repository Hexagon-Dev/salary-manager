<?php

namespace App\Services;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Models\Absence;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AbsenceService implements AbsenceServiceInterface
{
    protected ?Authenticatable $user;

    public function __construct(/*Authenticatable $absence*/)
    {
        //$this->user = $user;
        $this->user = auth()->user();
    }

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        if (!$this->user->can(['read', 'absence'])) {
            return Collection::make([
                'error' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        return Collection::make([
            'message' => Absence::all(),
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function readOne(int $id): Collection
    {
        if (!$this->user->can(['read', 'absence'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (! $absence = Absence::query()->where('id', $id)->first()) {
            return Collection::make([
                'message' => 'not_found',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        return Collection::make([
            'message' => $absence->toArray(),
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): Collection
    {
        if (!$this->user->can(['create', 'absence'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        $absence = Absence::query()->create($attributes);

        return Collection::make([
            'message' => $absence,
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return Collection
     */
    public function update(array $attributes, int $id): Collection
    {
        if (!$this->user->can(['update', 'absence'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (! $absence = Absence::query()->where('id', $id)->first()) {
            return Collection::make([
                'message' => 'not_found',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        $absence->update($attributes);

        return Collection::make([
            'message' => $absence->toArray(),
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function delete(int $id): Collection
    {
        if (!$this->user->can(['delete', 'absence'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (! $absence = Absence::query()->where('id', $id)->first()) {
            return Collection::make([
                'message' => 'not_found',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        $absence->delete();

        return Collection::make([
            'message' => 'deleted',
            'status' => Response::HTTP_OK,
        ]);
    }
}
