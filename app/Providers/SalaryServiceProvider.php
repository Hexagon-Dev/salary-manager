<?php

namespace App\Providers;

use App\Contracts\Services\SalaryServiceInterface;
use App\Services\SalaryService;
use Illuminate\Support\ServiceProvider;

class SalaryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(SalaryServiceInterface::class, SalaryService::class);
    }
}
