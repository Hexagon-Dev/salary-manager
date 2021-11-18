<?php

namespace App\Providers;

use App\Contracts\Services\SkillServiceInterface;
use App\Services\SkillService;
use Illuminate\Support\ServiceProvider;

class SkillServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(SkillServiceInterface::class, SkillService::class);
    }
}
