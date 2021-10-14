<?php

namespace JustBetter\LaravelErrorLogger;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootMigrations()
            ->bootTranslations();
    }

    protected function bootConfig(): self
    {
        $this->publishes([
            __DIR__ . '/../config/laravel-error-logger.php' => config_path('laravel-error-logger.php'),
        ], 'config');

        return $this;
    }

    protected function bootMigrations(): self
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        return $this;
    }

    protected function bootTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel-error-logger');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/laravel-error-logger'),
        ]);

        return $this;
    }
}
