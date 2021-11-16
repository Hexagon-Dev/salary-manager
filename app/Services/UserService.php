<?php

namespace App\Services;

use App\Contracts\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Permission;

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
        if (!User::can('create')) {
            return Collection::make(['error' => 'access_denied']);
        }

        if (User::get()->where('login', $request->login)->first()) {
            return Collection::make(['error' => 'user_exists']);
        }

        $user = User::query()->make($request->all());
        $user->password = Hash::make($user->password);
        $user->assignRole(Role::findByName('user'));
        $user->create($user->attributesToArray());

        return Collection::make(['message' => 'user_created']);
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function login(Request $request): Collection
    {
        $user = User::get()->where('login', $request->login)->first();
        if (Hash::check($request->password, $user->password)) {
            return Collection::make(['token' => JWTAuth::fromUser($user)]);
        }

        return Collection::make(['error' => 'invalid_password']);
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
