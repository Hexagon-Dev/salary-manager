<?php

namespace App\Contracts\Services;

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
    public function create(array $attributes): Collection;

    /**
     * @param string $login
     * @return Collection
     */
    public function readOne(string $login): Collection;

    /**
     * @param array $attributes
     * @param string $login
     * @return Collection
     */
    public function update(array $attributes, string $login): Collection;

    /**
     * @param string $login
     * @return Collection
     */
    public function delete(string $login): Collection;
}
