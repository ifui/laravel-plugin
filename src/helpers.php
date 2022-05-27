<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

if (!function_exists('plugin_path')) {
    /**
     * Get the plugin path.
     *
     * @param $plugin_name
     * @param string $dir
     * @return string
     */
    function plugin_path($plugin_name = null, string $dir = ''): string
    {
        return app('laravel-plugin')->getPath($plugin_name) .
            ($dir ? DIRECTORY_SEPARATOR . $dir : '');
    }
}

if (!function_exists('plugin_list')) {
    /**
     * List local plugins.
     *
     * @return Collection
     */
    function plugin_list(): Collection
    {
        return app('laravel-plugin')->getPlugins();
    }
}

if (!function_exists('plugin_namespace')) {
    /**
     * Get the plugin namespace.
     * If you give the plugin name. Will be return the plugin name of namespace.
     *
     * @param string $plugin_name
     * @param string $dir
     * @return string
     */
    function plugin_namespace(string $plugin_name = '', string $dir = 'App'): string
    {
        $pluginNameSpace = Config::get('laravel-plugin.namespace', 'Plugins');

        if ($plugin_name) {
            return Str::studly($pluginNameSpace) . '\\' . Str::studly($plugin_name) . '\\' . $dir;
        } else {
            return Str::studly($pluginNameSpace);
        }
    }
}
