<?php

namespace App\Providers;

use App\Contracts\Services\PersoneServiceInterface;
use App\Services\PersoneService;
use Illuminate\Support\ServiceProvider;

class PersoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PersoneServiceInterface::class, PersoneService::class);
    }
}
