<?php

namespace Ifui\LaravelPlugin\Commands\Database\Traits;

trait PluginMigrateCommandTraits
{
    /**
     * Get all the migration paths.
     *
     * @return array
     */
    protected function getMigrationPaths()
    {
        // Here, we will check to see if a path option has been defined. If it has we will
        // use the path relative to the root of the installation folder so our database
        // migrations may be run for any customized path from within the application.
        if ($this->input->hasOption('path') && $this->option('path')) {
            return collect($this->option('path'))
                ->map(function ($path) {
                    return !$this->usingRealPath()
                        ? $this->laravel->basePath() . '/' . $path
                        : $path;
                })
                ->all();
        }

        // Only migration the plugins.
        return $this->getPluginMigrationPaths();
    }

    /**
     * Get the plugin path to the migration directory.
     *
     * @return array
     */
    protected function getPluginMigrationPaths(): array
    {
        $pluginPath = plugin_path();
        $plugins = plugin_list();

        return $plugins
            ->map(function ($plugin) use ($pluginPath) {
                return $pluginPath .
                    DIRECTORY_SEPARATOR .
                    $plugin->name .
                    DIRECTORY_SEPARATOR .
                    'Database' .
                    DIRECTORY_SEPARATOR .
                    'Migrations';
            })
            ->toArray();
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath(): string
    {
        $pluginPath = plugin_path($this->argument('plugin'));

        return $pluginPath . DIRECTORY_SEPARATOR . 'Database' . DIRECTORY_SEPARATOR . 'Migrations';
    }
}
