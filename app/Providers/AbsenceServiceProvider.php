<?php

namespace App\Providers;

use App\Contracts\Services\AbsenceServiceInterface;
use App\Services\AbsenceService;
use Illuminate\Support\ServiceProvider;

class AbsenceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(AbsenceServiceInterface::class, AbsenceService::class);
    }
}
