<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestHelper
{
    public static function getUser($login): Model|Builder
    {
        return User::query()->where('login', $login)->firstOrFail();
    }
}
