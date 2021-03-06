<?php

namespace Ifui\LaravelPlugin\Providers;

use Exception;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Psy\Readline\Hoa\Console;

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
                    try {
                        $this->app->register($provider);
                    } catch (Exception) {
                        echo "{$pluginProvider->name} does not exist! Please update the plugin.json or run php artisan plugin:rescan.";
                    }
                }
            }
        }
    }
}
