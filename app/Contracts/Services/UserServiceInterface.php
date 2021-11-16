<?php

namespace App\Contracts\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

interface UserServiceInterface
{

    /**
     * @param Authenticatable $user
     * @return self
     */
    public function setUser(Authenticatable $user): self;

    /**
     * @return Collection
     */
    public function index(): Collection;

    /**
     * @param array $attributes
     * @return Collection
     */
    public function create(array $attributes): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function show(string $login): Collection;

    /**
     * @param array $attributes
     * @param int $id
     * @return Collection
     */
    public function update(array $attributes, int $id): Collection;

    /**
     * @param int $id
     * @return Collection
     */
    public function delete(int $id): Collection;
}
