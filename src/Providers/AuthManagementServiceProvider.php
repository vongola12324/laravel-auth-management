<?php

namespace Vongola\Auth\Providers;

use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Vongola\Auth\Listeners\AuthEventSubscriber;
use Vongola\Auth\Services\AuthService;

class AuthManagementServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../Config/auth-management.php' => config_path('auth-management.php'),
        ], 'config');
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthService::class, function ($app) {
            return new AuthService();
        });

        if (config('auth-management.enable')) {
            Event::subscribe(AuthEventSubscriber::class);
        }
    }
}