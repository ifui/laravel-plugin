<?php

namespace Ifui\LaravelPlugin\Commands\Factories;

use Ifui\LaravelPlugin\Commands\Traits\PluginGeneratorCommandTraits;
use Illuminate\Database\Console\Factories\FactoryMakeCommand as BaseFactoryMakeCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'plugin:make-factory')]
class FactoryMakeCommand extends BaseFactoryMakeCommand
{
    use PluginGeneratorCommandTraits;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-factory';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'plugin:make-factory';

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name): string
    {
        $oldNameSpace = 'Database\Factories';

        $factoryNameSpace = str_replace(
            '/',
            '\\',
            Config::get('laravel-plugin.paths.generator.factory')
        );

        $newNameSpace = plugin_namespace($this->argument('plugin'), $factoryNameSpace);

        return str_replace($oldNameSpace, $newNameSpace, parent::buildClass($name));
    }

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = (string) Str::of($name)
            ->replaceFirst($this->rootNamespace(), '')
            ->finish('Factory');

        $factoryPath =
            plugin_path($this->argument('plugin')) .
            DIRECTORY_SEPARATOR .
            Config::get('laravel-plugin.paths.generator.factory');

        $filename = str_replace('\\', '/', $name) . '.php';

        return $factoryPath . DIRECTORY_SEPARATOR . $filename;
    }
}
