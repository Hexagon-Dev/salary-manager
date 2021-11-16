<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserService implements UserServiceInterface
{
    public ?Authenticatable $user;

    /**
     * @param Authenticatable $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function setUser(Authenticatable $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection
     */
    public function index(): Collection
    {
        $this->user->can('view');
        return User::all();
    }

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): Collection
    {
        $this->user->can('create');

        if (User::get()->where('login', $attributes['login'])->first()) {
            return Collection::make(['error' => 'user_exists']);
        }

        $user = User::query()->make($attributes);
        $user->password = Hash::make($user->password);
        $user->assignRole(Role::findByName('user'));
        $user->create($user->attributesToArray());

        return Collection::make(['message' => 'user_created']);
    }

    /**
     * @param string $login
     * @return Collection
     */
    public function show(string $login): Collection
    {
        $this->user->can('view');

        return Collection::make(User::query()->get()->where('login', $login)->first()->toArray());
    }

    /**
     * @param array $attributes
     * @param int $id
     * @return Collection
     */
    public function update(array $attributes, int $id): Collection
    {
        $this->user->can('edit');

        $user = User::query()->findOrFail($id);
        $user->update($attributes->all());

        return Collection::make($user);
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function delete(int $id): Collection
    {
        $this->user->can('delete');

        $article = User::query()->findOrFail($id);
        $article->delete();

        return Collection::make(['message' => 'user_deleted']);
    }
}
