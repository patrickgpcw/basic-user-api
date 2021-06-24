<?php

namespace App\Providers;

use App\Services\SaltGeneratorService;
use Illuminate\Support\ServiceProvider;

class SaltGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('salt', SaltGeneratorService::class);
        $this->app->bind(SaltGeneratorContract::class, SaltGeneratorService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
