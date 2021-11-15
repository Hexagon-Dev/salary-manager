<?php

namespace App\Providers;

use App\Contracts\Services\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }
}
