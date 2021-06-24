<?php

namespace App\Providers;

use App\Contracts\JWTValidatorContract;
use App\Services\JWTValidatorService;
use Illuminate\Support\ServiceProvider;

class JWTValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(JWTValidatorContract::class, JWTValidatorService::class);
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
