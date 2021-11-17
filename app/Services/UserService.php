<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserService implements UserServiceInterface
{
    protected ?Authenticatable $user;

    public function __construct(/*Authenticatable $user*/)
    {
        //$this->user = $user;
        $this->user = auth()->user() ?? User::query()->findOrFail('3');
    }

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        if (!$this->user->can(['read', 'user'])) {
            return Collection::make([
                'error' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        return Collection::make([
            'message' => User::all(),
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function readOne(string $login): Collection
    {
        if (!$this->user->can(['read', 'user'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (! User::query()->where('login', $login)->first()) {
            return Collection::make([
                'message' => 'not_found',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        return Collection::make([
            'message' => User::query()->get()->where('login', $login)->first()->toArray(),
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): Collection
    {
        if (!$this->user->can(['create', 'user'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (User::get()->where('login', $attributes['login'])->first()) {
            return Collection::make([
                'message' => 'user_exists',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        $user = User::query()->make($attributes);
        $user->password = Hash::make($user->password);
        $user->assignRole(Role::findByName('user'));
        $user->create($user->attributesToArray());

        return Collection::make([
            'message' => $user,
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param array $attributes
     * @param string $login
     * @return Collection
     */
    public function update(array $attributes, string $login): Collection
    {
        if (!$this->user->can(['update', 'user'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (! $user = User::query()->where('login', $login)->first()) {
            return Collection::make([
                'message' => 'not_found',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        $user->update($attributes);

        return Collection::make([
            'message' => $user->toArray(),
            'status' => Response::HTTP_OK,
        ]);
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function delete(string $login): Collection
    {
        if (!$this->user->can(['delete', 'user'])) {
            return Collection::make([
                'message' => 'access_denied',
                'status' => Response::HTTP_FORBIDDEN,
            ]);
        }

        if (! $user = User::query()->where('login', $login)->first()) {
            return Collection::make([
                'message' => 'not_found',
                'status' => Response::HTTP_NOT_FOUND,
            ]);
        }

        $user->delete();

        return Collection::make([
            'message' => 'deleted',
            'status' => Response::HTTP_OK,
        ]);
    }
}
