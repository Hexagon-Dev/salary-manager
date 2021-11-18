<?php

namespace App\Providers;

use App\Contracts\Services\NoteServiceInterface;
use App\Services\NoteService;
use Illuminate\Support\ServiceProvider;

class NoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(NoteServiceInterface::class, NoteService::class);
    }
}
