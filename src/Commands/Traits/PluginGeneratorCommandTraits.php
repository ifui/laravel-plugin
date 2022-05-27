<?php

namespace Ifui\LaravelPlugin\Commands\Traits;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

trait PluginGeneratorCommandTraits
{
    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        $pluginPath = plugin_path($this->argument('plugin'));

        $filePath =
            DIRECTORY_SEPARATOR .
            'App' .
            DIRECTORY_SEPARATOR .
            str_replace('\\', '/', $name) .
            '.php';

        return $pluginPath . $filePath;
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace(): string
    {
        $pluginNameSpace = Config::get('laravel-plugin.namespace', 'Plugins');

        return Str::studly($pluginNameSpace) .
            '\\' .
            Str::studly($this->argument('plugin')) .
            '\\App\\';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return array_merge(parent::getArguments(), [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin'],
        ]);
    }
}
