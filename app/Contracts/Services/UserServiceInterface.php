<?php

namespace App\Contracts\Services;

use App\Models\User;
use http\Env\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface UserServiceInterface
{

    /**
     * @return Collection
     */
    public function readAll(): Collection;

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): User;

    /**
     * @param string $login
     * @return User|Model
     */
    public function readOne(string $login): Model;

    /**
     * @param User $user
     * @param array $attributes
     * @return User
     */
    public function update(User $user, array $attributes): User;

    /**
     * @param User $user
     * @return int
     */
    public function delete(User $user): int;
}
