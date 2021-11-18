<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TestHelper
{
    public static function getUser($login): Model|Builder
    {
        $user = User::query()->where('login', $login)->firstOrFail();
        //$user->update(['password' => 'superadmin']);

        return $user;
    }
}
