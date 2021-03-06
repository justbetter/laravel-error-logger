<?php

namespace JustBetter\ErrorLogger;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use JustBetter\ErrorLogger\Console\Commands\PruneCommand;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }
    
    public function boot(): void
    {
        $this
            ->bootConfig()
            ->bootCommands()
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

    protected function bootCommands(): self
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PruneCommand::class,
            ]);
        }

        return $this;
    }

    protected function bootMigrations(): self
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        return $this;
    }

    protected function bootTranslations(): self
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel-error-logger');

        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/laravel-error-logger'),
        ]);

        return $this;
    }
}
