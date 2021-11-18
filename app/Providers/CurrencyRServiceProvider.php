<?php

namespace App\Providers;

use App\Contracts\Services\CurrencyRecordServiceInterface;
use App\Services\CurrencyRecordService;
use Illuminate\Support\ServiceProvider;

class CurrencyRServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CurrencyRecordServiceInterface::class, CurrencyRecordService::class);
    }
}
