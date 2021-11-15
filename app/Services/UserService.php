<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService implements UserServiceInterface
{
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return User::all();
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function create(Request $request): Collection
    {
        $token = JWTAuth::attempt($request->only('login', 'password'));
        dd($token);
        return Collection::make(User::query()->create($input->toArray())->toArray());
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function show(int $id): Collection
    {
        return Collection::make(User::query()->find($id));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Collection
     */
    public function update(Request $request, int $id): Collection
    {
        $article = User::query()->findOrFail($id);
        $article->update($request->all());

        return Collection::make($article);
    }

    /**
     * @param int $id
     * @return int
     */
    public function delete(int $id): int
    {
        $article = User::query()->findOrFail($id);
        $article->delete();

        return 200;
    }
}
