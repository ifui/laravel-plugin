<?php

namespace Ifui\LaravelPlugin\Providers;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class RegisterPluginServiceProvider extends ServiceProvider
{
    /**
     * Booting the package.
     */
    public function boot(): void
    {
    }

    /**
     * Register the activity providers.
     * @throws Exception
     */
    public function register(): void
    {
        $pluginProviders = $this->app['laravel-plugin']->getPlugins();

        foreach ($pluginProviders as $pluginProvider) {
            if ($pluginProvider->active) {
                foreach ($pluginProvider->providers as $provider) {
                    class_exists($provider) && $this->app->register($provider);
                }
            }
        }
    }
}
