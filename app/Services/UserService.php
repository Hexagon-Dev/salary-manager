<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserService implements UserServiceInterface
{
    /**
     * @return Collection
     */
    public function readAll(): Collection
    {
        return User::all();
    }

    /**
     * @param string $login
     * @return User|Model
     */
    public function readOne(string $login): Model
    {
        return User::query()->where('login', $login)->firstOrFail();
    }

    /**
     * @param array $attributes
     * @return User
     */
    public function create(array $attributes): User
    {
        $attributes['password'] = Hash::make($attributes['password']);

        /** @var User $user */
        $user = User::query()->create($attributes);
        $user->assignRole(Role::findByName('user'));

        return $user;
    }

    /**
     * @param User $user
     * @param array $attributes
     * @return User
     */
    public function update(User $user, array $attributes): User
    {
        $user->update($attributes);

        return $user;
    }

    /**
     * @param User $user
     * @return int
     */
    public function delete(User $user): int
    {
        $user->delete();

        return Response::HTTP_OK;
    }
}
