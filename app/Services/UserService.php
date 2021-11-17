<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Dflydev\DotAccessData\Data;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService implements UserServiceInterface
{
    protected ?Authenticatable $user;

    public function __construct(/*Authenticatable $user*/)
    {
        //$this->user = $user;
        $this->user = auth()->user();
        //dd($this->user->getRoleNames()->first());
        //dd($this->user->getAllPermissions()->toArray());
        //dd($this->user->can(['delete', 'user']));
    }

    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        if (!$this->user->can(['read', 'user'])) {
            return Collection::make(['error' => 'access_denied']);
        }

        return User::all();
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function readOne(string $login): Collection
    {
        if (!$this->user->can(['read', 'user'])) {
            return Collection::make(['error' => 'access_denied']);
        }

        if (! User::query()->where('login', $login)->first()) {
            return Collection::make(['error' => 'not_found']);
        }

        return Collection::make(User::query()->get()->where('login', $login)->first()->toArray());
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): Collection
    {
        if (!$this->user->can(['create', 'user'])) {
            return Collection::make(['error' => 'access_denied']);
        }

        if (User::get()->where('login', $attributes['login'])->first()) {
            return Collection::make(['error' => 'user_exists']);
        }

        $user = User::query()->make($attributes);
        $user->password = Hash::make($user->password);
        $user->assignRole(Role::findByName('user'));
        $user->create($user->attributesToArray());

        return Collection::make($user);
    }

    /**
     * @param array $attributes
     * @param string $login
     * @return Collection
     */
    public function update(array $attributes, string $login): Collection
    {
        if (!$this->user->can(['update', 'user'])) {
            return Collection::make(['error' => 'access_denied']);
        }

        if (! $user = User::query()->where('login', $login)->first()) {
            return Collection::make(['error' => 'not_found']);
        }

        $user->update($attributes);

        return Collection::make($user->toArray());
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function delete(string $login): Collection
    {
        if (!$this->user->can(['delete', 'user'])) {
            return Collection::make(['error' => 'access_denied']);
        }

        if (! $user = User::query()->where('login', $login)->first()) {
            return Collection::make(['error' => 'not_found']);
        }

        $user->delete();

        return Collection::make(['message' => 'deleted']);
    }
}
