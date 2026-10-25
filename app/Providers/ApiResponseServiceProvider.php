<?php

namespace App\Providers;

use App\API\Res\ResponseBuilder;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('apiResponse', fn () => new ResponseBuilder);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
