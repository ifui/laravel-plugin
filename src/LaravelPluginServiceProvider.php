<?php

namespace Ifui\LaravelPlugin;

use Ifui\LaravelPlugin\Contracts\LaravelPluginInterface;
use Ifui\LaravelPlugin\Providers\ConsoleServiceProvider;
use Ifui\LaravelPlugin\Providers\RegisterPluginServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LaravelPluginServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ifui');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-plugin');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->registerRoutes();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-plugin.php', 'laravel-plugin');

        // Register the service the package provides.
        $this->app->singleton(LaravelPluginInterface::class, function ($app) {
            $path = $app['config']->get('laravel-plugin.paths.plugin');
            return new LaravelPlugin($app, $path);
        });
        $this->app->alias(LaravelPluginInterface::class, 'laravel-plugin');

        // Register ConsoleServiceProvider
        $this->app->register(ConsoleServiceProvider::class);

        // Register RegisterPluginServiceProvider
        $this->app->register(RegisterPluginServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['laravel-plugin'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes(
            [
                __DIR__ . '/../config/laravel-plugin.php' => config_path('laravel-plugin.php'),
            ],
            'laravel-plugin.config'
        );

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/ifui'),
        ], 'laravel-plugin.views');*/

        // Publishing assets.
        // $this->publishes([
        //  __DIR__ . '/../public' => public_path('vendor/ifui'),
        // ], 'laravel-plugin.public');

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/ifui'),
        ], 'laravel-plugin.views');*/

        // Registering package commands.
        // $this->commands([]);
    }

    /**
     * Register the package routes.
     *
     * @return void
     */
    private function registerRoutes(): void
    {
        Route::group($this->routeConfiguration(), function () {
            $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
        });
    }

    /**
     * Get the Laravel Plugin route group configuration array.
     *
     * @return array
     */
    private function routeConfiguration(): array
    {
        return [
            'namespace' => 'Ifui\LaravelPlugin\Http\Controllers',
            'prefix' => config('laravel-plugin.url_prefix'),
        ];
    }
}
