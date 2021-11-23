<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use HasRoles;

    protected $guarded = [];

    public function setPasswordAttribute($value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
